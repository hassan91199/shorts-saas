<?php

return [

    /*
    |--------------------------------------------------------------------------
    | API Base URL
    |--------------------------------------------------------------------------
    |
    | This option controls the base URL for the API used by the video generation
    | service. This URL is used to make requests to the API to fetch video
    | information and other related data. You can set this URL in your .env
    | file and it will be used to build API request URLs throughout the application.
    |
    | Example: "http://localhost:31415"
    |
    */

    'api_base_url' => env('VID_GEN_API_BASE_URL', 'http://localhost:31415'),
];
