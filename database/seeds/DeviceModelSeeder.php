<?php

use Illuminate\Database\Seeder;

class DeviceModelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        collect([
            'Firefox', 'Chrome', 'Safari', 'IE', 'Opera'
        ])->each(function($model) {

            DB::insert('INSERT INTO device_models(name) VALUES("'. $model .'")');
        });
    }
}
