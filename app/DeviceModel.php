<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceModel extends Model
{
    public static function findByModelName(string $name) {

        return self::where(['name' => $name])->firstOrFail();
    }
}
