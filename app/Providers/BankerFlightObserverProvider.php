<?php

namespace App\Providers;

use App\BankerFlight;
use App\Observers\BankerFlightObserver;
use Illuminate\Support\ServiceProvider;

class BankerFlightObserverProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        BankerFlight::observe(BankerFlightObserver::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
