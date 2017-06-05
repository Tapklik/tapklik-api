<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{

    // Methods

    public static function findByUuId($uuid)
    {
        return self::where(['uuid' => $uuid])->firstOrFail();
    }
}
