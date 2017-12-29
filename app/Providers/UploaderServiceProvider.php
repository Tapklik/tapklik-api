<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Tapklik\Storage\Adapters\S3StorageAdapter;
use Tapklik\Storage\Container;
use Tapklik\Uploader\Contracts\AbstractUploader;
use Tapklik\Uploader\Drivers\ZipDriver;
use Tapklik\Uploader\Service;

class UploaderServiceProvider extends ServiceProvider
{
    private $request = false;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(AbstractUploader::class, function ($app) {

            // Load driver based on extension

            $driver   = new ZipDriver(env('UPLOAD_DIR'));
            $adapter  = new S3StorageAdapter(
                ['region'      => getenv('AWS_REGION'),
                 'version'     => '2006-03-01',
                 'credentials' => ['key'    => getenv('AWS_ACCESS_KEY'),
                                   'secret' => getenv('AWS_SECRET_KEY')]]
            );
            $storage  = new Container($adapter);

            return new Service($driver, $storage);
        });
    }
}
