<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceModel extends Model
{
    public function device()
    {
        return $this->morphMany(Device::class, 'devicable');
    }
}
