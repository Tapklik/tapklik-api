<?php

namespace App\Providers;

use App\Creative;
use App\Observers\CreativeObserver;
use Illuminate\Support\ServiceProvider;

class CreativeObserverProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Creative::observe(CreativeObserver::class);
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
