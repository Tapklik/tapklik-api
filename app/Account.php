<?php namespace App;

class Account extends ModelSetup
{

    // Relationships

    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Methods

    public static function findByUuId($uuid)
    {
        return self::where(['uuid' => $uuid])->firstOrFail();
    }
}
