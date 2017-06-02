<?php namespace App;

class Campaign extends ModelSetup
{

    // Relationships
    public function advertiserDomains()
    {

        return $this->hasMany(AdvertiserDomain::class);
    }

    public function exchanges()
    {

        return $this->hasMany(Exchange::class);
    }

    // Custom Methods

    public static function findByUuId($uuid)
    {

        return Campaign::where(['uuid' => $uuid])->firstOrFail();
    }
}
