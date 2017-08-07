<?php namespace App;

use App\Contracts\BankerInterface;

class BankerFlight extends ModelSetup implements BankerInterface
{
    protected $table = 'banker_flight';

    public function flightable()
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
}
