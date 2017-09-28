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
            'email' => 'user',
            'password' => bcrypt('user'),
            'account_id' => 1
        ]);

        factory(\App\User::class)->create([
            'email' => 'admin',
            'password' => bcrypt('admin'),
            'account_id' => 1,
            'is_admin' => 1
        ]);
    }
}
