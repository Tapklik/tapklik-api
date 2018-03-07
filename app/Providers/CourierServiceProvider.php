<?php

namespace App\Providers;

use App\Packages\Courier\Contracts\AbstractCourier;
use App\Packages\Courier\Courier;
use App\Packages\Courier\Drivers\OneadDriver;
use Illuminate\Support\ServiceProvider;

class CourierServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        return $this->app->bind(AbstractCourier::class, function () {

        	    return new Courier();
        });
    }
}
