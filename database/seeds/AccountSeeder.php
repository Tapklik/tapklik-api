<?php

use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Account::create([
            'name' => 'Tapklik',
            'country' => 'UAE',
            'city' => 'Dubai',
            'timezone' => 'Dubai/UAE',
            'language' => 'en',
            'status' => 1,
            'company' => 'Tapklik',
            'billing_address' => 'Dubai',
            'billing_email' => 'info@tapklik.com',
            'billing_country' => 'Dubai',
            'billing_city' => 'Dubai',
        ]);

    }
}
