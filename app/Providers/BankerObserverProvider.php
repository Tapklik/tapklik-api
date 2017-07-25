<?php

namespace App\Providers;

use App\Banker;
use App\Observers\BankerObserver;
use Illuminate\Support\ServiceProvider;

class BankerObserverProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Banker::observe(BankerObserver::class);
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
