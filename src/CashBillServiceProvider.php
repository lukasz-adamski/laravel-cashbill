<?php

namespace Adams\CashBill;

use Illuminate\Support\ServiceProvider;

class CashBillServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            $this->configFilePath() => config_path('cashbill.php')
        ], 'config');

        $this->loadRoutes();

        $this->app->bind('cashbill', function () {
            return new CashBill();
        });
    }

    /**
     * Load routes to default payment controller.
     * 
     * @return void
     */
    protected function loadRoutes()
    {
        if (config('cashbill.package_routes', false)) {
            return;
        }
        
        $this->loadRoutesFrom(
            $this->routesFilePath()
        );
    }
    
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            $this->configFilePath(), 'cashbill'
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            CashBill::class
        ];
    }

    /**
     * Get module config file path.
     * 
     * @return string
     */
    protected function configFilePath()
    {
        return realpath(__DIR__ . '/../config/cashbill.php');
    }

    /**
     * Get module routes path.
     * 
     * @return string
     */
    protected function routesFilePath()
    {
        return realpath(__DIR__ . '/../routes/cashbill.php');
    }
}