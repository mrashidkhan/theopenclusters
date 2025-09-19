<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Google Services Configuration
    |--------------------------------------------------------------------------
    */

    'gtm' => [
        'container_id' => env('GTM_CONTAINER_ID'),
    ],

    'google_analytics' => [
        'measurement_id' => env('GA_MEASUREMENT_ID'), // GA4 Measurement ID (G-XXXXXXXXXX)
        'tracking_id' => env('GA_TRACKING_ID'), // Universal Analytics (if still using)
    ],

    'google_search_console' => [
        'verification_code' => env('GSC_VERIFICATION_CODE'),
    ],

    'google_adsense' => [
        'client_id' => env('ADSENSE_CLIENT_ID'),
    ],

    'facebook_pixel' => [
        'pixel_id' => env('FACEBOOK_PIXEL_ID'),
    ],

    'structured_data' => [
        'organization_name' => env('ORGANIZATION_NAME', config('app.name')),
        'organization_url' => env('ORGANIZATION_URL', config('app.url')),
        'organization_logo' => env('ORGANIZATION_LOGO'),
        'default_author' => env('DEFAULT_AUTHOR'),
    ],
];
