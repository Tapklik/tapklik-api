<?php

use App\Account;
use App\Campaign;
use App\Creative;
use App\Folder;
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

        (new AccountSeeder)->run();
        (new CategoriesSeeder)->run();
        (new DeviceTypeSeeder)->run();
        (new DeviceModelSeeder)->run();
        (new DeviceOsSeeder)->run();
        (new UserSeeder)->run();
        (new CampaignSeeder())->run();
        (new ExchangesSeeder())->run();
    }
}
