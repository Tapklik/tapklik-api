<?php

namespace App\Providers;

use App\Folder;
use App\Observers\FolderObserver;
use Illuminate\Support\ServiceProvider;

class FolderObserverProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Folder::observe(FolderObserver::class);
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
