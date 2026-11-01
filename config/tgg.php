<?php
return [
    // Shown on tax invoices, so it must never be blank
    'abn' => env('TGG_ABN') ?: '61 173 928 602',

    // Dates on invoices are in the shop's local time
    'timezone' => 'Australia/Melbourne',

    // Gets a copy of every order email, and payment alerts
    'sales_email' => env('TGG_SALES_EMAIL', 'sales@toadgully.com.au'),
];
