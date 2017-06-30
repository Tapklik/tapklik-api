<?php namespace App;

class DeviceOs extends ModelSetup
{
    public function device()
    {
        return $this->morphMany(Device::class, 'devicable');
    }
}
