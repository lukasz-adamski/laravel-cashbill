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
@TODO

## Testing
To run predefined test set use:
```bash
php vendor/bin/phpunit
```
