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

    public function geography()
    {

        return $this->belongsToMany(Geography::class);
    }

    public function budget()
    {

        return $this->hasOne(Budget::class);
    }

    public function account()
    {

        return $this->hasOne(Account::class, 'id', 'account_id');
    }

    // Custom Methods

    public static function findByUuId($uuid)
    {

        return Campaign::where(['uuid' => $uuid])->firstOrFail();
    }

    public static function findByAccountId($id)
    {

        return Campaign::where(['account_id' => $id])->get();
    }

}
