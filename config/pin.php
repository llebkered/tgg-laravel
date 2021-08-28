<?php
return [
    'host' => env('PIN_HOST', 'test-api.pinpayments.com'),
    'secret' => env('PIN_SECRET', 'LB0rLeJfIJo93JcddiCS1w'), // 'bar' is default if MY_VALUE is missing in .env
    'publishable' => env('PIN_PUBLISABLE', 'pk_cROvzVNnR6rfQ5WI0g2fbw')
];
