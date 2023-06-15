<?php

namespace Service\Payment\Providers;

use Illuminate\Support\ServiceProvider;

/*
|--------------------------------------------------
| Service provider for handling the control of Payment gateways
|--------------------------------------------------
| Written By- linh .
| github: https://github.com/linh20000/gateway
*/
class AppServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(){
        $this->loadMigrationsFrom(__DIR__.'/../Momo/Database/migrations');
        $this->loadMigrationsFrom(__DIR__.'/../Vnpay/Database/migrations');
        $this->loadViewsFrom(__DIR__.'/../view','payment');
        $this->loadViewsFrom(__DIR__.'/../view','result');
        $this->publishes([
            __DIR__.'/../config/momo.php' => config_path('momo.php'),
            __DIR__.'/../config/vnpay.php' => config_path('vnpay.php'),
        ], 'config-api');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(){
        
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides(){
        return [
          //
        ];
    }
}