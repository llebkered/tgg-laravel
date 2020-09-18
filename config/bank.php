<?php
return [
    'name' => env('BANK_NAME',''),
    'bsb' => env('BANK_BSB', ''), // 'bar' is default if MY_VALUE is missing in .env
    'account' => env('BANK_ACCOUNT', '')
];
