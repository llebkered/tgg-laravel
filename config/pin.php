<?php
return [
    // test-api.pinpayments.com for testing, api.pinpayments.com for live payments
    'host' => env('PIN_HOST', 'test-api.pinpayments.com'),

    // Keys must be set in .env. There are no defaults, so a missing key fails
    // loudly instead of falling back to someone else's account.
    'secret' => env('PIN_SECRET'),
    'publishable' => env('PIN_PUBLISHABLE'),
];
