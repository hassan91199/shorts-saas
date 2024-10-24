<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Product;
use Stripe\Price as StripePrice;
use Stripe\Stripe;
use App\Models\Plan;
use App\Models\Price as PriceModel;
use Carbon\Carbon;
use Stripe\Customer;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{
    /**
     * Display the page to show details 
     * of current plan and billing.
     */
    public function billing()
    {
        $frequencyByPlan = [
            'starter' => 'Three times a week',
            'daily' => 'Once a day',
            'hardcore' => 'Twice a day',
        ];

        $user = auth()->user();
        $isStripeCustomer = $user->hasStripeId();
        $isUserLoggedIn = isset($user) ? 'true' : 'false';
        $isUserSubscribed = $user->subscribed('starter') || $user->subscribed('daily') || $user->subscribed('hardcore');

        $subscription = $user?->subscriptions()?->active()?->first() ?? null;

        if (isset($subscription)) {
            $userSubscribedPlan = $subscription->type;
            $planPrice = PriceModel::where('stripe_price_id', $subscription->stripe_price)->first();
            $userSubscribedPlanBillingCycle = $planPrice->billing_cycle;
            $userSubscribedPlanQuantity = $subscription->quantity;

            $currentPlan = ucwords($userSubscribedPlan) . ' (' . ($userSubscribedPlanBillingCycle == 'month' ? 'Monthly' : 'Yearly') . ')';
            $maxSeries = $userSubscribedPlanQuantity;
            $frequency = $frequencyByPlan[$userSubscribedPlan];
            $subscriptionStatus = 'Active';

            $nextBillingDate = Carbon::parse($subscription->created_at);
            if ($userSubscribedPlanBillingCycle == 'year') {
                $nextBillingDate->addYear();
            } else {
                $nextBillingDate->addMonth();
            }
            $nextBillingDate = $nextBillingDate->format('M j, Y');

            $price = (int) $planPrice->price * $maxSeries;
        } else {
            $userSubscribedPlan = '';
            $userSubscribedPlanBillingCycle = '';
            $userSubscribedPlanQuantity = '';

            $currentPlan = 'Free';
            $maxSeries = 1;
            $frequency = 'Never';
            $subscriptionStatus = 'Inactive';
            $nextBillingDate = 'N/A';
            $price = 0;
        }

        return view('subscription.billing', [
            'isStripeCustomer' => $isStripeCustomer,

            'isUserLoggedIn' => $isUserLoggedIn,
            'isUserSubscribed' => $isUserSubscribed,

            'userSubscribedPlan' => $userSubscribedPlan,
            'userSubscribedPlanBillingCycle' => $userSubscribedPlanBillingCycle,
            'userSubscribedPlanQuantity' => $userSubscribedPlanQuantity,

            'currentPlan' => $currentPlan,
            'maxSeries' => $maxSeries,
            'frequency' => $frequency,
            'subscriptionStatus' => $subscriptionStatus,
            'nextBillingDate' => $nextBillingDate,
            'price' => $price,
        ]);
    }

    public function subscribe(Request $request)
    {
        $user = $request->user();

        // Get input data
        $planName = $request->input('plan_name');
        $billingCycle = $request->input('billing_cycle');
        $numSeries = (int) $request->input('num_series');

        Stripe::setApiKey(config('stripe.secret'));

        // Check or create the product
        $plan = Plan::where('name', $planName)->first();

        if (!$plan) {
            $stripeProduct = $this->getStripeProductByName($planName) ?? Product::create([
                'name' => $planName,
                'type' => 'service',
            ]);

            $plan = Plan::create([
                'name' => $planName,
                'stripe_product_id' => $stripeProduct->id,
            ]);
        }

        // Check or create the price
        $priceAmount = $this->calculatePrice($planName, $billingCycle);
        $price = PriceModel::where('plan_id', $plan->id)
            ->where('billing_cycle', $billingCycle)
            ->where('price', $priceAmount)
            ->first();

        if (!$price) {
            $stripePrice = $this->getStripePriceByProduct($plan->stripe_product_id, $billingCycle, $priceAmount) ?? StripePrice::create([
                'unit_amount' => $priceAmount * 100, // In cents
                'currency' => 'usd',
                'recurring' => ['interval' => $billingCycle],
                'product' => $plan->stripe_product_id,
            ]);

            $price = PriceModel::create([
                'plan_id' => $plan->id,
                'stripe_price_id' => $stripePrice->id,
                'billing_cycle' => $billingCycle,
                'price' => $priceAmount,
            ]);
        }

        // Create or update the stripe customer id if it doesn't exists
        if (!isset($user->stripe_id)) {
            $stripeCustomer = $this->getStripeCustomerByEmail($user->email);

            if (!$stripeCustomer) {
                $stripeCustomer = Customer::create([
                    'email' => $user->email,
                    'name' => $user->name
                ]);
            }

            $user->stripe_id = $stripeCustomer->id;
            $user->save();
        }

        return $user->newSubscription($planName, $price->stripe_price_id)
            ->quantity($numSeries)
            ->checkout([
                'success_url' => route('series.index', ['checkout' => 'success']),
                'cancel_url' => route('series.index', ['checkout' => 'cancel']),
            ]);
    }

    public function unsubscribe()
    {
        $user = auth()->user();

        $subscriptions = $user->subscriptions()->active()->get();

        if ($subscriptions->count() > 0) {
            // Cancel all subscriptions of the logged-in user
            foreach ($subscriptions as $subscription) {
                $subscription->cancelNow();
            }
        }

        return redirect()->back()->with('success', 'You have successfully selected the free plan.');
    }

    private function getStripeProductByName($productName)
    {
        $products = Product::all(['limit' => 100]);

        foreach ($products->data as $product) {
            if ($product->name === $productName) {
                return $product;
            }
        }

        return null;
    }

    private function getStripeCustomerByEmail($email)
    {
        $customers = Customer::search(['query' => 'email:"' . $email . '"']);

        return $customers->data[0] ?? null;
    }

    private function getStripePriceByProduct($productId, $billingCycle, $priceAmount)
    {
        $prices = StripePrice::all(['limit' => 100, 'product' => $productId]);

        foreach ($prices->data as $price) {
            if ($price->recurring && $price->recurring->interval === $billingCycle && $price->unit_amount === $priceAmount * 100) {
                return $price;
            }
        }

        return null;
    }

    private function calculatePrice($planName, $billingCycle)
    {
        $prices = [
            'starter' => [
                'month' => 19,
                'year' => 192,
            ],
            'daily' => [
                'month' => 39,
                'year' => 369,
            ],
            'hardcore' => [
                'month' => 69,
                'year' => 696,
            ],
        ];

        return $prices[$planName][$billingCycle] ?? 0;
    }
}
