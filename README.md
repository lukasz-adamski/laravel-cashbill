# CashBill payment processor for Laravel
Laravel package which provides CashBill payment processor support.

## Installation
1. Install composer package using command:
```
composer require lukasz-adamski/laravel-cashbill
```

2. Add Service Provider in `config/app.php`:
```php
Adams\CashBill\CashBillServiceProvider::class,
```

3. Add Facade in `config/app.php`:
```php
'CashBill' => Adams\CashBill\Facades\Facade::class,
```

4. Publish configuration file to your project:
```php
php artisan vendor:publish --provider="Adams\CashBill\CashBillServiceProvider"
```

5. If you have `package_routes` setting enabled you need to except `/webhook/cashbill` route from CSRF verification in `app/Http/Middleware/VerifyCsrfToken.php`:
```php
/**
 * The URIs that should be excluded from CSRF verification.
 *
 * @var array
 */
protected $except = [
    '/webhook/cashbill'
];
```

## Environment
You can setup these environment variables to configure CashBill API access:
- `CASHBILL_MODE` - Current API mode, by default this value is set to `sandbox` to test implementation. On production you need to set this value to `live`,
- `CASHBILL_SHOP_ID` - Your shop identifier received from payment provider,
- `CASHBILL_TOKEN` - Random string received from payment provider to sign API requests,
- `CASHBILL_CURRENCY_CODE` _(optional)_ - Default currency code for payments (default currency code: PLN).

## Testing
To run predefined test set use:
```bash
php vendor/bin/phpunit
```

## Usage
Example payment controller implementation:
```php
<?php

namespace App\Http\Controllers;

use CashBill;
use Adams\CashBill\Payment;
use App\Http\Controllers\Controller;

class ExampleController extends Controller
{
    /**
     * Redirect user to payment provider.
     *
     * @return Response
     */
    public function pay()
    {
        $payment = new Payment();
        $payment->setTitle('Title');
        $payment->setDescription('My item description');
        $payment->setData('... additional transaction data ...');
        
        // Currency code is set from 'payment_defaults.currency_code' in config file.
        $payment->setAmount(10); 

        return CashBill::redirect($payload);
    }
}
```
