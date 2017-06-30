<?php

use Illuminate\Database\Seeder;

class DeviceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([2,4,5])->each(function($type) {

            DB::insert('INSERT INTO device_types(type_id) VALUES("'. $type .'")');
        });
    }
}
