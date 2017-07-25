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
    App\Budget::class,
    function (Faker\Generator $faker) {

        return [
            'type'   => 'daily',
            'amount' => 0,
            'pacing' => '1111110111111011111101111110111111011111101111110',
        ];
    }
);
