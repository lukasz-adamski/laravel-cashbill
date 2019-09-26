<?php

/*
|--------------------------------------------------------------------------
| CashBill Routes
|--------------------------------------------------------------------------
|
| This file define all routes used by package to process incoming
| transactions from payment provider.
|
*/

Route::namespace('\Adams\CashBill\Http\Controllers')->group(function () {

    Route::name('webhook.cashbill')->get(
        'webhook/cashbill',
        'WebhookController@handle'
    );

});