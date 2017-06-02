<?php namespace App;

class Campaign extends ModelSetup
{

    // Custom Methods
    public static function findByUuId($uuid)
    {
        return Campaign::where(['uuid' => $uuid])->firstOrFail();
    }

}
