<?php namespace App;

/**
 * Class Creative
 *
 * @package App
 */
class Creative extends ModelSetup implements Uuidable
{
    // Methods

    /**
     * @param string $uuid
     *
     * @return mixed
     */
    public static function findByUuId(string $uuid) {

        return self::where(['uuid' => $uuid])->firstOrFail();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function folder() {

        return $this->belongsTo(Folder::class);
    }

    public function attributes() {

        return $this->hasMany(Attribute::class);
    }

    public function makeCreative($object = [])
    {

        return new self($object);
    }

    public static function generateAdm($campaignId, $creativeId)
    {
        return '<iframe src="' . getenv('AD_SERVER_URL') . '/serve/' . $campaignId . '/' . $creativeId . '?{{BIDDER_ATTR}}" ></iframe>';
    }
}
