<?php

return [
    'secure' => env('WELLNESS_SECURE', '***'),
    'client_id' => env('WELLNESS_CLIENT_ID', '***'),
    'client_secret' => env('WELLNESS_CLIENT_SECRET', '***'),
    'url' => [
        'rest_one_day' => env('WELLNESS_URL_REST_ONE_DAY', '***'),
        'rest_three_days' => env('WELLNESS_URL_REST_THREE_DAYS', '***')
    ]
];
