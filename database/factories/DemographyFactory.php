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
    App\Demography::class,
    function (Faker\Generator $faker) {

        return [
            'gender'   => ['F', 'M'],
            'from_age' => 1,
            'to_age'   => 120,
        ];
    }
);
