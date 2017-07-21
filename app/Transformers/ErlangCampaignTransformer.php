<?php namespace App\Transformers;

use App\Campaign;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class ErlangCampaignTransformer extends TransformerAbstract
{
    protected $defaultIncludes = [ 'creatives'];

    /**
     * @param \App\Campaign $campaign
     *
     * @return array
     */
    public function transform(Campaign $campaign)
    {

        return [
            'id'          => $campaign->uuid,
            'name'        => $campaign->name,
            'description' => $campaign->description,
            'start_time'  => $campaign->start,
            'end_time'    => $campaign->end,
            'bid'         => $campaign->bid,
            'ctrurl'      => $campaign->ctrurl,
            'adomain'      => $campaign->adomain,
            'test'        => $campaign->test,
            'weight'      => $campaign->weight,
            'node'        => $campaign->node,
            'approved'    => $campaign->approved,
            'status'      => $campaign->status,
            'device'      => $campaign->device,
        ];
    }

    public function includeCreatives(Campaign $campaign) 
    {

        return $this->collection($campaign->creatives, new ErlangCreativeTransformer);
    }



}
