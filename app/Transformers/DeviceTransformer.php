<?php namespace App\Transformers;

use App\Device;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class DeviceTransformer extends TransformerAbstract
{

    /**
     * @param \App\Device $device
     *
     * @return array
     */
    public function transform(Device $device)
    {

        return [
            'type'  => $device->pluck('type'),
            'make'  => $device->pluck('make'),
            'model' =>  $device->pluck('model'),
            'os'    =>  $device->pluck('operating_system'),
            'ua'    =>  $device->pluck('user_agent'),
        ];
    }
}
