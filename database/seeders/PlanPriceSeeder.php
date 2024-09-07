<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Price;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Stripe\Price as StripePrice;
use Stripe\Product;
use Stripe\Stripe;

class PlanPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stripe::setApiKey(config('stripe.secret'));

        $plans = [
            'free' => [
                'name' => 'Free',
                'prices' => [
                    ['amount' => 0, 'billing_cycle' => 'month'],
                    ['amount' => 0, 'billing_cycle' => 'year']
                ],
            ],
            'starter' => [
                'name' => 'Starter',
                'prices' => [
                    ['amount' => 19, 'billing_cycle' => 'month'],
                    ['amount' => 192, 'billing_cycle' => 'year']
                ],
            ],
            'daily' => [
                'name' => 'Daily',
                'prices' => [
                    ['amount' => 39, 'billing_cycle' => 'month'],
                    ['amount' => 369, 'billing_cycle' => 'year']
                ],
            ],
            'hardcore' => [
                'name' => 'Hardcore',
                'prices' => [
                    ['amount' => 69, 'billing_cycle' => 'month'],
                    ['amount' => 696, 'billing_cycle' => 'year']
                ],
            ],
        ];

        foreach ($plans as $planKey => $planData) {
            $plan = Plan::where('name', $planData['name'])->first();

            if (!$plan) {
                // Check if the Stripe product exists, if not, create it
                $stripeProduct = $this->getStripeProductByName($planData['name']) ?? Product::create([
                    'name' => $planData['name'],
                    'type' => 'service',
                ]);

                // Create the plan in the local database
                $plan = Plan::create([
                    'name' => $planData['name'],
                    'stripe_product_id' => $stripeProduct->id,
                ]);
            }

            // Create prices for the plan
            foreach ($planData['prices'] as $priceData) {
                // Check if price exists in the database
                $existingPrice = Price::where('plan_id', $plan->id)
                    ->where('billing_cycle', $priceData['billing_cycle'])
                    ->first();

                if (!$existingPrice) {
                    // Create the price on Stripe
                    $stripePrice = $this->getStripePriceByProduct($plan->stripe_product_id, $priceData['billing_cycle']) ?? StripePrice::create([
                        'unit_amount' => $priceData['amount'] * 100, // Converting to cents
                        'currency' => 'usd',
                        'recurring' => ['interval' => $priceData['billing_cycle']],
                        'product' => $plan->stripe_product_id,
                    ]);

                    // Store the price in the local database
                    Price::create([
                        'plan_id' => $plan->id,
                        'stripe_price_id' => $stripePrice->id,
                        'billing_cycle' => $priceData['billing_cycle'],
                        'price' => $priceData['amount'],
                    ]);
                }
            }
        }
    }

    private function getStripeProductByName($productName)
    {
        $products =  Product::all(['limit' => 100]); // will replace this with PHP_INT_MAX

        foreach ($products->data as $product) {
            if ($product->name === $productName) {
                return $product;
            }
        }

        return null;
    }

    private function getStripePriceByProduct($productId, $billingCycle)
    {
        $prices = StripePrice::all(['limit' => 100, 'product' => $productId]); // will replace this with PHP_INT_MAX

        foreach ($prices->data as $price) {
            if ($price->recurring && $price->recurring->interval === $billingCycle) {
                return $price;
            }
        }

        return null;
    }
}
