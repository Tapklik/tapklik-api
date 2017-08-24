<?php

use Illuminate\Database\Seeder;

class CampaignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $campaign = factory(App\Campaign::class)->create(['account_id' => 1]);
        $deviceType = \App\DeviceType::find(1);
        $deviceModel = \App\DeviceModel::find(1);
        $deviceOs = \App\DeviceOs::find(1);

        $campaign->deviceTypes()->save($deviceType);
        $campaign->deviceModels()->save($deviceModel);
        $campaign->deviceOperatingSystems()->save($deviceOs);
    }
}
