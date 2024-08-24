<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Google API Client ID
    |--------------------------------------------------------------------------
    |
    | This option controls the client ID used for authenticating with Google APIs.
    | This ID is provided by Google and is used to identify your application
    | when making API requests. You can use the same client ID for multiple APIs.
    |
    */

    'client_id' => env('GOOGLE_CLIENT_ID', 'your-client-id'),

    /*
    |--------------------------------------------------------------------------
    | Google API Client Secret
    |--------------------------------------------------------------------------
    |
    | This option controls the client secret used for authenticating with Google APIs.
    | This secret is provided by Google and should be kept secure. It can be used
    | for multiple APIs if they are part of the same project.
    |
    */

    'client_secret' => env('GOOGLE_CLIENT_SECRET', 'your-client-secret'),

    /*
    |--------------------------------------------------------------------------
    | Google API Redirect URI
    |--------------------------------------------------------------------------
    |
    | This option controls the redirect URI used after authentication with Google APIs.
    | This URI is where users are redirected after they grant permissions to your application.
    |
    */

    'redirect_uri' => env('GOOGLE_REDIRECT_URI', 'http://localhost:7155/google/callback'),

    /*
    |--------------------------------------------------------------------------
    | Google API Project ID
    |--------------------------------------------------------------------------
    |
    | This option controls the project ID associated with your Google API client.
    | This ID is provided by Google and is used to identify your project.
    |
    */

    'project_id' => env('GOOGLE_PROJECT_ID', 'your-project-id'),

    /*
    |--------------------------------------------------------------------------
    | Google API Scopes
    |--------------------------------------------------------------------------
    |
    | This option defines the scopes required for different Google APIs. Scopes determine
    | the level of access granted to your application. You can define scopes for different
    | APIs based on your application's needs.
    |
    */

    'scopes' => [
        'youtube' => [
            'https://www.googleapis.com/auth/youtube.upload',
            'https://www.googleapis.com/auth/youtube'
        ],
    ],
];
