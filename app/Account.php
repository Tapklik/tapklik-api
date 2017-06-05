<?php namespace App;

class Account extends ModelSetup
{

    // Methods

    public static function findByUuId($uuid)
    {
        return self::where(['uuid' => $uuid])->firstOrFail();
    }
}
