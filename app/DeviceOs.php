<?php namespace App;

class DeviceOs extends ModelSetup
{
    public static function findByOsName(string $name) {

        return self::where(['name' => $name])->firstOrFail();
    }
}
