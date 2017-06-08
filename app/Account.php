<?php namespace App;

class Account extends ModelSetup
{

    // Relationships

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function campaigns() {

        return $this->hasMany(Campaign::class);
    }

    // Methods

    public static function findByUuId($uuid)
    {
        return self::where(['uuid' => $uuid])->firstOrFail();
    }
}
