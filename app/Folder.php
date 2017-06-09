<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{

    // Methods

    public static function findByAccountId(int $id)
    {

        return self::where(['account_id' => $id])->get();
    }
}
