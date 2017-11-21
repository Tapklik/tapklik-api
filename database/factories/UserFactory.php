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
    App\User::class,
    function (Faker\Generator $faker) {

        return [
            'account_id'     => factory(\App\Account::class)->create()->id,
            'first_name'     => $faker->firstName,
            'last_name'      => $faker->lastName,
            'email'          => $faker->unique()->safeEmail,
            'password'       => bcrypt('secret'),
            'remember_token' => str_random(10),
            'tutorial'       => rand(0,1),
            'status'         => rand(0, 1),
        ];
    }
);
