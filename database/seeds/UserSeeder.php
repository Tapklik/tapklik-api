<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\User::class)->create([
            'email' => 'halid@tapklik.com',
            'password' => bcrypt('halid1234'),
            'first_name' => 'Halid',
            'last_name' => 'Mousa',
            'account_id' => 1,
            'is_admin' => 1,
            'status' => 1
        ]);

    }
}