<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class HandleReferralCommission
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        if ($event->payload['type'] === 'invoice.payment_succeeded') {
            $invoice = $event->payload['data']['object'];
            $customerId = $invoice['customer'];

            $user = User::where('stripe_id', $customerId)->first();

            if ($user) {
                $referrer = $user->referrer;

                if ($referrer && $user->referrer_successful_conversion) {
                    $amount = $invoice['amount_paid'] / 100; // Converting to dollars

                    // Calculate the 30% commission for referrer
                    $commission = $amount * 0.30;

                    // Update the unpaid commission of the referrer
                    $referrer->unpaid_commission += $commission;
                    $referrer->save();
                }
            }
        }
    }
}
