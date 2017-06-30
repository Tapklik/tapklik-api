<?php namespace App;

class DeviceType extends ModelSetup
{

    public static function findByTypeId(int $id) {

        return self::where(['type_id' => $id])->firstOrFail();
    }
}
