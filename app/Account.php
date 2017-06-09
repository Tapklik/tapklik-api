<?php namespace App;

/**
 * Class Account
 *
 * @package App
 */
class Account extends ModelSetup
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

    // Methods

    /**
     * @param $uuid
     *
     * @return mixed
     */
    public static function findByUuId($uuid)
    {
        return self::where(['uuid' => $uuid])->firstOrFail();
    }
}
