<?php

use Illuminate\Database\Seeder;

/**
 * Class ExchangesSeeder
 *
 * @package \\${NAMESPACE}
 */
class ExchangesSeeder extends Seeder
{

    public function run() {

        \App\AccountExchange::create([
            'identifier' => 3,
            'name'      => 'Google',
            'endpoint'  => 'https://adexchangebuyer.googleapis.com',
            'seatId'    => 123,
            'billingId' => 456,
            'token'     => '',
            'prefix'    => '%%CLICK_URL_UNESC%%',
            'postfix'   => '',
        ]);
    }
}
