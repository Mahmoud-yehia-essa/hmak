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


    'facebook' => [
    'pixel_id'      => env('2286018608511604'),
    'access_token'  => env('EAAVeXhBZBZC0gBPXZBG7HaclkJOQWPBZBLDSYMtzqqOLBhU5nZC2WGZBL5v3hhQi1vzXYMOURA1ZBwvq17y9XFVMJMgtKWG8qINrx5mCI2fW0VDA1OR12ThBEZCAKVaDrZCmZBsCi1wxWnTPEy71ZAO85lAzHLOQzqvzp5wgmvhcZAI21n0GlE9IgIQc8BUUkPA88QZDZD'),
],


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

];
