<?php namespace App\Transformers;

use App\Campaign;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class DeviceTransformer extends TransformerAbstract
{

    /**
     * @param \App\Campaign $campaign
     *
     * @return array
     */
    public function transform(Campaign $campaign)
    {

        return [
            'type'  => $campaign->deviceTypes()->pluck('type_id'),
            'make'  => [],
            'model' => [],
            'os'    => $campaign->deviceOperatingSystems()->pluck('id'),
            'ua'    => $campaign->deviceModels()->pluck('id'),
        ];
    }
}
