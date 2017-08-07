<?php namespace App;

class BankerFlight extends ModelSetup
{
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
