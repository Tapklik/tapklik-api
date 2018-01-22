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
            'account_id' => 1,
            'is_admin' => 1,
            'status' => 1
        ]);

        factory(\App\User::class)->create([
            'email' => 'rok@tapklik.com',
            'password' => bcrypt('rok1234'),
            'account_id' => 1,
            'is_admin' => 1,
            'status' => 1
        ]);

        factory(\App\User::class)->create([
            'email' => 'user@test1.com',
            'password' => bcrypt('user1'),
            'account_id' => 2,
            'status' => 1
        ]);
    }
}
