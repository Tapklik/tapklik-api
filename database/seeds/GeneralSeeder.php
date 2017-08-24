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

        $account   = factory(Account::class)->create();
        $campaign  = factory(Campaign::class)->create(['account_id' => $account->id]);
        $folder    = factory(Folder::class)->create(['account_id' => $account->id]);
        $creatives = factory(Creative::class)->create(['folder_id' => $folder->id]);

        (new CategoriesSeeder)->run();
        (new DeviceTypeSeeder)->run();
        (new DeviceModelSeeder)->run();
        (new DeviceOsSeeder)->run();
        (new UserSeeder)->run();
        (new DemographySeeder)->run();
        (new CampaignSeeder())->run();
    }
}
