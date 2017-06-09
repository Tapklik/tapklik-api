<?php namespace App;

/**
 * Class Folder
 *
 * @package App
 */
class Folder extends ModelSetup
{

    // Relationships

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function creatives() {

        return $this->hasMany(Creative::class);
    }
    // Methods

    /**
     * @param int $id
     *
     * @return mixed
     */
    public static function findByAccountId(int $id)
    {

        return self::where(['account_id' => $id])->get();
    }

    /**
     * @param string $uuid
     *
     * @return mixed
     */
    public static function findByUuId(string $uuid)
    {

        return self::where(['uuid' => $uuid])->firstOrFail();
    }
}
