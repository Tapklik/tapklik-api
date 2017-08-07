<?php namespace App;

use App\Contracts\BankerInterface;

class BankerMain extends ModelSetup implements BankerInterface
{
    protected $table = 'banker_main';

    public function mainable()
    {
        return $this->morphTo();
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public static function findByUuId($uuid)
    {
        return self::where(['uuid' => $uuid])->firstOrFail();
    }
}
