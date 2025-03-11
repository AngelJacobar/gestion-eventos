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

    'recaptcha' => [
        'verify_url' => 'https://www.google.com/recaptcha/api/siteverify',
        'enable' => env('RECAPTCHA_ENABLED', false),
        'site_key' => env('RECAPTCHA_SITE_KEY', ''),
        'secret_key' => env('RECAPTCHA_SECRET_KEY', ''),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],
    'idu' => [
        'register' => env('IDU_REGISTER', false),
        'sso' => env('IDU_SSO', false),
        'url' => env('IDU_URL', '/'),
        'client_id' => env('IDU_ID', ''),
        'client_secret' => env('IDU_SECRET', ''),
        'redirect' => env('IDU_REDIRECT_URL', env('APP_URL', '')),
        'scopes' => env('IDU_SCOPES', ''),
    ],

];
