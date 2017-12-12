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
    App\Campaign::class,
    function (Faker\Generator $faker) {

        $generator = new Tapklik\Identicus\Generator();
        $uuid      = $generator->generateUniqueId(10);

        $status = collect(['active', 'stopped', 'archived'])->offsetGet(2);

        return ['uuid'        => $uuid,
                'account_id'  => factory(\App\Account::class)->create()->id,
                'name'        => $faker->company,
                'description' => $faker->sentences(4, true),
                'start'       => ($start = \Carbon\Carbon::now())->toDateString(),
                'end'         => $start->addDays(3)->toDateString(),
                'bid'         => rand(10, 100),
                'ctrurl'      => $faker->url,
                'adomain'     => $faker->domainName,
                'test'        => rand(0, 1),
                'weight'      => rand(0, 5),
                'node'        => "",
                'status'      => 'active',];
    }
);
