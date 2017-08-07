<?php namespace App\Providers;

use App\BankerMain;
use App\Observers\BankerObserver;
use Illuminate\Support\ServiceProvider;

class BankerMainObserverProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        BankerMain::observe(BankerMainObserver::class);
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
