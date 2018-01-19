<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(
    App\Publisher::class,
    function (Faker\Generator $faker) {

        return [
            '_id' => 'pub-' . rand(1000, 9999),
            'publisher_site' => $faker->url
        ];
    }
);
