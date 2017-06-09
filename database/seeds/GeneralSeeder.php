<?php

use Illuminate\Database\Seeder;

class GeneralSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $account  = factory(\App\Account::class)->create();
        $user     = factory(\App\User::class)->create(['account_id' => $account->id]);
        $campaign = factory(App\Campaign::class)->create(['account_id' => $account->id]);
        $folders  = factory(\App\Folder::class, 20)->create(['account_id' => $account->id]);
    }
}
