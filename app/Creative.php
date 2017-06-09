<?php namespace App;

/**
 * Class Creative
 *
 * @package App
 */
class Creative extends ModelSetup
{
    // Methods

    /**
     * @param string $uuid
     *
     * @return mixed
     */
    public static function findByUuId(string $uuid) {

        return self::where(['uuid' => $uuid]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function folder() {

        return $this->belongsTo(Folder::class);
    }
}
