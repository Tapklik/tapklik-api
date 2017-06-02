<?php

namespace App\Providers;

use App\Http\Response\FractalResponse;
use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager;
use League\Fractal\Serializer\DataArraySerializer;
use League\Fractal\Serializer\SerializerAbstract;

class FractalResponseProvider extends ServiceProvider
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
        $this->app->bind(
        	SerializerAbstract::class,
	        DataArraySerializer::class
        );

	    $this->app->bind(FractalResponse::class, function ($app) {
		    $manager = new Manager();
		    $serializer = $app[SerializerAbstract::class];

		    return new FractalResponse($manager, $serializer);
	    });

	    $this->app->alias(FractalResponse::class, 'fractal');
    }
}
