<?php namespace App;

/**
 * Class Campaign
 *
 * @package App
 */
class Campaign extends ModelSetup
{

    // Relationships

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function advertiserDomains()
    {

        return $this->hasMany(AdvertiserDomain::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function exchanges()
    {

        return $this->hasMany(Exchange::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {

        return $this->belongsToMany(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function demography()
    {

        return $this->hasOne(Demography::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function creatives()
    {

        return $this->belongsToMany(Creative::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function geography()
    {

        return $this->belongsToMany(Geography::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function budget()
    {

        return $this->hasOne(Budget::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function account()
    {

        return $this->hasOne(Account::class, 'id', 'account_id');
    }

    // Custom Methods

    /**
     * @param $uuid
     *
     * @return mixed
     */
    public static function findByUuId($uuid)
    {

        return Campaign::where(['uuid' => $uuid])->firstOrFail();
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public static function findByAccountId($id)
    {

        return Campaign::where(['account_id' => $id])->get();
    }

}
