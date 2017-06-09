<?php namespace App;

class Folder extends ModelSetup
{

    // Relationships

    public function creatives()
    {

        return $this->hasMany(Creative::class);
    }

    // Methods

    public static function findByAccountId(int $id)
    {

        return self::where(['account_id' => $id])->get();
    }
}
