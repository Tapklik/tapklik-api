<?php namespace App;

use App\Contracts\Bankerable;
use Carbon\Carbon;

/**
 * Class Campaign
 *
 * @package App
 */
class Campaign extends ModelSetup implements Uuidable, Bankerable
{

    // Relationships

    /**
     * @param string $uuid
     *
     * @return mixed
     */
    public static function findByUuId(string $uuid)
    {
       return Campaign::where(['uuid' => $uuid])->firstOrFail();
    }

    /**
     * @param        $id
     *
     * @return mixed
     */
    public static function findByAccountId($id)
    {
        return Campaign::where(['account_id' => $id])->get();
    }

    public static function balance($uuid)
    {
        $campaign = self::where(['uuid' => $uuid])->firstOrFail();

        $credit = $campaign->banker()->sum('credit');
        $debit  = $campaign->banker()->sum('debit');

        return $credit - $debit;
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

    public function main()
    {
        return $this->morphMany(BankerMain::class, 'mainable');
    }

    public function flight()
    {
        return $this->morphMany(BankerFlight::class, 'flightable');
    }

    public function spend()
    {
        return $this->morphMany(BankerSpend::class, 'spendable');
    }

    public static function toStart() {

    	    return self::where('start', '>=', Carbon::now())->where(['status' => 'not started']);
    }

    public static function toExpire() {

	    return self::where('end', '<', Carbon::now())->where(['status' => 'active']);
    }


//    public function setBidAttribute($value) {
//
//        $this->attributes['bid'] = $value * 1000000;
//    }
//
//    public function getBidAttribute($value)
//    {
//        return number_format($value / 1000000, 2);
//    }

}
