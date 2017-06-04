<?php namespace App;

class Campaign extends ModelSetup
{

    // Relationships
    public static function findByUuId($uuid)
    {

        return Campaign::where(['uuid' => $uuid])->firstOrFail();
    }

    public function advertiserDomains()
    {

        return $this->hasMany(AdvertiserDomain::class);
    }

    public function exchanges()
    {

        return $this->hasMany(Exchange::class);
    }

    public function categories()
    {

        return $this->belongsToMany(Category::class);
    }

    public function demography()
    {

        return $this->hasOne(Demography::class);
    }

    public function creatives()
    {

        return $this->belongsToMany(Creative::class);
    }

    // Custom Methods

    public function budget()
    {

        return $this->hasOne(Budget::class);
    }
}
