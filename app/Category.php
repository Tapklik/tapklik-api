<?php namespace App;

/**
 * Class Category
 *
 * @package App
 */
class Category extends ModelSetup
{

    // Methods

    /**
     * @param $code
     *
     * @return mixed
     */
    public static function findByIabCode($code)
    {
        return self::where(['code' => trim($code)])->firstOrFail();
    }
}
