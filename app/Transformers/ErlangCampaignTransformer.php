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
    protected $defaultIncludes = [ 'creatives', 'cat', 'device', 'exchange', 'budget', 'geo', 'user'];

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
            'account_id'  => $campaign->account->uuid,
            'description' => $campaign->description,
            'start_time'  => $campaign->start,
            'end_time'    => $campaign->end,
            'bid'         => $campaign->bid,
            'ctrurl'      => $campaign->ctrurl,
            'adomain'     => $campaign->adomain,
            'test'        => $campaign->test,
            'weight'      => $campaign->weight,
            'node'        => $campaign->node,
            'status'      => $campaign->status,
        ];
    }

    public function includeExchange(Campaign $campaign)
    {

        return $this->collection($campaign->exchanges, new ExchangeTransformer);
    }

    public function includeCat(Campaign $campaign)
    {

        return $this->collection($campaign->categories, new CategoryTransformer);
    }

    public function includeBudget(Campaign $campaign)
    {

        return $this->item($campaign->budget ?: new Budget, new BudgetTransformer);
    }

    public function includeCreatives(Campaign $campaign) 
    {

        return $this->collection($campaign->creatives, new ErlangCreativeTransformer);
    }



    public function includeUser(Campaign $campaign)
    {

        return $this->item($campaign->demography ?: new Demography, new DemographyTransformer);
    }

    public function includeGeo(Campaign $campaign)
    {

        return $this->collection($campaign->geography ?: new Geography, new GeographyTransformer);
    }

    public function includeDevice(Campaign $campaign)
    {

        return $this->item($campaign, new DeviceTransformer);
    }



}
