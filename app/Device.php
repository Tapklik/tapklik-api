<?php namespace App;

class Device extends ModelSetup
{
    public function devicable()
    {
        return $this->morphTo();
    }
}
