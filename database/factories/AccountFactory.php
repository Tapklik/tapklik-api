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
    App\Account::class,
    function (Faker\Generator $faker) {

        return ['name'            => $faker->company,
                'country'         => $faker->countryISOAlpha3,
                'city'            => $faker->city,
                'timezone'        => $faker->timezone,
                'language'        => $faker->languageCode,
                'company'         => $faker->company,
                'billing_address' => $faker->address,
                'billing_email'   => $faker->companyEmail,
                'billing_country' => $faker->country,
                'billing_city'    => $faker->city,
                'status'          => rand(0, 1),];
    }
);
