<?php

use Illuminate\Database\Seeder;

class DeviceOsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
            'Android', 'BlackBerry', 'iOS', 'Mac OS', 'Linux', 'Windows'
        ])->each(function($os) {

            DB::insert('INSERT INTO device_os(name) VALUES("'. $os .'")');
        });
    }
}
