<?php namespace App;

class BankerSpend extends ModelSetup
{
    public function spendable()
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
