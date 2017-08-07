<?php namespace App;

/**
 * Class Account
 *
 * @package App
 */
class Account extends ModelSetup implements Uuidable
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

    public function mainable()
    {
        return $this->morphMany(BankerMain::class, 'mainable');
    }

    public function flightable()
    {
        return $this->morphMany(BankerFlight::class, 'flightable');
    }

    public function spendable()
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
