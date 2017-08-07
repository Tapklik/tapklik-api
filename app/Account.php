<?php namespace App;

use App\Contracts\Bankerable;

/**
 * Class Account
 *
 * @package App
 */
class Account extends ModelSetup implements Uuidable, Bankerable
{

    // Relationships

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function campaigns() {

        return $this->hasMany(Campaign::class);
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

    // Methods

    /**
     * @param $uuid
     *
     * @return mixed
     */
    public static function findByUuId(string $uuid)
    {
        return self::where(['uuid' => $uuid])->firstOrFail();
    }
}
