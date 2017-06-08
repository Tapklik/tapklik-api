<?php namespace App;

class Category extends ModelSetup
{

    // Methods

    public static function findByIabCode($code)
    {
        return self::where(['code' => trim($code)])->firstOrFail();
    }
}
