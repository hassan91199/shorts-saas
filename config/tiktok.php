<?php

return [

    /*
    |--------------------------------------------------------------------------
    | TikTok API Client Key
    |--------------------------------------------------------------------------
    |
    | This option controls the client key used for authenticating with TikTok APIs.
    | This key is provided by TikTok and is used to identify your application
    | when making API requests. You can use the same client key for multiple APIs
    | if they are part of the same project.
    |
    */

    'client_key' => env('TIKTOK_CLIENT_KEY'),

    /*
    |--------------------------------------------------------------------------
    | TikTok API Client Secret
    |--------------------------------------------------------------------------
    |
    | This option controls the client secret used for authenticating with TikTok APIs.
    | This secret is provided by TikTok and should be kept secure. It can be used
    | for multiple APIs if they are part of the same project.
    |
    */

    'client_secret' => env('TIKTOK_CLIENT_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | TikTok API Redirect URI
    |--------------------------------------------------------------------------
    |
    | This option controls the redirect URI used after authentication with TikTok APIs.
    | This URI is where users are redirected after they grant permissions to your application.
    |
    */

    'redirect_uri' => env('TIKTOK_REDIRECT_URI'),

    /*
    |--------------------------------------------------------------------------
    | TikTok API Scopes
    |--------------------------------------------------------------------------
    |
    | This option defines the scopes required for different TikTok APIs. Scopes determine
    | the level of access granted to your application. You can define scopes based on 
    | your application's needs.
    |
    */

    'scopes' => [
        'user.info.basic',
        'video.publish',
        'video.upload',
    ],
];
