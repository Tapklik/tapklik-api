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
     * @param $uuid
     *
     * @return mixed
     */
    public static function findByUuId($uuid)
    {

        return Campaign::where(['uuid' => $uuid])->firstOrFail();
    }

    public function approvedCreatives() {

        return Creative::where(['campaign_id' => $this->$id, 'status' => 'approved']);
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

    public function deviceTypes()
    {

        return $this->belongsToMany(DeviceType::class);
    }

    // Custom Methods

    public function deviceModels()
    {

        return $this->belongsToMany(DeviceModel::class);
    }

    public function deviceOperatingSystems()
    {

        return $this->belongsToMany(DeviceOs::class);
    }

}
