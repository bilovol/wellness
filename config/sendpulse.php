<?php
/**
 * @see \App\Providers\SendpulseServiceClientProvider
 */
return [
    'api' => [
        'url' => env('SENDPULSE_API_URL', 'https://api.sendpulse.com')

    ],
    "token" => [
        "prefix" => env('SENDPULSE_TOKEN_PREFIX', 'sp:token:'),
        "storage" => env('SENDPULSE_TOKEN_STORAGE', 'redis'),
        "ttl" => env('SENDPULSE_TOKEN_TTL', 1000)
    ],
];
