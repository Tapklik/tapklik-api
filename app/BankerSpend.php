<?php namespace App;

use App\Contracts\BankerInterface;

class BankerSpend extends ModelSetup implements BankerInterface
{
    protected $table = 'banker_spend';

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
