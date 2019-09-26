<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Endpoint Mode
    |--------------------------------------------------------------------------
    |
    | This setting determine which endpoint will be used to process
    | transactions. Available options: live, sandbox
    |
    */

    'mode' => env('CASHBILL_MODE', 'sandbox'),

    /*
    |--------------------------------------------------------------------------
    | Shop ID
    |--------------------------------------------------------------------------
    |
    | Shop ID available in the payment provider panel after logging in.
    |
    */

    'shop_id' => env('CASHBILL_SHOP_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | Token
    |--------------------------------------------------------------------------
    |
    | The string of characters available in the panel on the payment 
    | provider's website for signing the transaction.
    |
    */

    'token' => env('CASHBILL_TOKEN', ''),

    /*
    |--------------------------------------------------------------------------
    | Payment Defaults
    |--------------------------------------------------------------------------
    |
    | Default payment fields set automatically for all new transactions.
    |
    */

    'payment_defaults' => [
        'currency_code' => env('CASHBILL_CURRENCY_CODE', 'PLN'),
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Disable Package Routes
    |--------------------------------------------------------------------------
    |
    | Here you can disable the default transaction processor provided 
    | with this package.
    |
    */

    'package_routes' => false
    
];