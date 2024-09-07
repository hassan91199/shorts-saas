<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Stripe API Keys
    |--------------------------------------------------------------------------
    |
    | The Stripe publishable key and secret key for your application. These
    | keys can be found in your Stripe dashboard and are required to interact
    | with the Stripe API. The webhook secret is optional and used for 
    | verifying Stripe webhooks.
    |
    */

    'key' => env('STRIPE_KEY'),
    'secret' => env('STRIPE_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Stripe Webhook Secret
    |--------------------------------------------------------------------------
    |
    | If you are handling webhooks from Stripe, you'll want to set the webhook
    | secret here to validate that incoming webhooks are indeed from Stripe.
    |
    */

    'webhook_secret' => env('STRIPE_WEBHOOK_SECRET', null),
];
