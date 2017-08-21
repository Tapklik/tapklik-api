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
    App\BankerMain::class,
    function (Faker\Generator $faker) {

        return ['debit'       => rand(10, 1000),
                'credit'      => rand(10, 1000),
                'description' => $faker->colorName];
    }
);

$factory->state(
    \App\BankerMain::class,
    'withTypeBilling',
    function (Faker\Generator $faker) {

        return ['type' => 'billing'];
});


$factory->state(
    \App\BankerMain::class,
    'withTypeSystem',
    function (Faker\Generator $faker) {

        return ['type' => 'system'];
});
