<?php namespace App;

class Campaign extends ModelSetup
{

    // Relationships
    public static function findByUuId($uuid)
    {

        return Campaign::where(['uuid' => $uuid])->firstOrFail();
    }

    // Custom Methods

    public function advertiserDomains()
    {

        return $this->hasMany(AdvertiserDomain::class);
    }

}
