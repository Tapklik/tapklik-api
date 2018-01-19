<?php namespace App;

class Publisher extends ModelSetup
{
    public static function findById(string $id) {

        return self::where(['_id' => $id])->firstOrFail();
    }
}
