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
    App\Creative::class,
    function (Faker\Generator $faker) {

        $uuid     = \Ramsey\Uuid\Uuid::uuid1();
        $approved = collect(['approved', 'pending', 'declined'])->offsetGet(2);

        return [
            'uuid'       => $uuid->toString(),
            'expdir'     => 0,
            'adm'        => "<iframe id='a3b53e1d' name='a3b53e1d' src='http://adserver.tapklik.com/www/delivery/afr.php?zoneid=1&amp;cb=12323' frameborder='0' scrolling='no' width='300' height='250'><a href='http://adserver.tapklik.com/www/delivery/ck.php?n=a9d047cc&amp;cb=123432' target='_blank'><img src='http://adserver.tapklik.com/www/delivery/avw.php?zoneid=1&amp;cb=12343&amp;n=a9d047cc' border='0' alt='' /></a></iframe>",
            'ctrurl'     => $faker->domainName,
            'iurl'       => $faker->imageUrl(),
            'type'       => 1077,
            'pos'        => 0,
            'status'     => $approved,
        ];
    }
);
