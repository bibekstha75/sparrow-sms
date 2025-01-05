<?php

return [
    'token' => env('SPARROW_SMS_TOKEN'),
    'from' => env('SPARROW_SMS_FROM', 'TheAlert'),
    'url' => env('SPARROW_SMS_URL'),
    'credit_url' => env('SPARROW_SMS_CREDIT_URL'),
    'enable_logging' => env('SPARROW_SMS_ENABLE_LOGGING', false),
];
