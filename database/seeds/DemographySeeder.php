<?php

use Illuminate\Database\Seeder;

class DemographySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Demography::class)->create(['campaign_id' => 1]);
    }
}
