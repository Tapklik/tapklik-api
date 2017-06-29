<?php namespace App;

class Geography extends ModelSetup
{

    public static function findByKey($key)
    {

        return self::where('key', 'LIKE', "%$key%")->get();
    }
}
