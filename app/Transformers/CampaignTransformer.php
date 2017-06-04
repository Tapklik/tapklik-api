<?php namespace App\Transformers;

use App\Budget;
use App\Campaign;
use App\Creative;
use App\Demography;
use App\Geography;
use App\Device;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class CampaignTransformer extends TransformerAbstract
{

    /**
     * @var array
     */
    protected $defaultIncludes = ['adomain', 'exchange', 'cat', 'budget', 'user', 'creatives'];

//    protected $defaultIncludes = ['geo', 'creatives', 'device'];

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
            'test'        => $campaign->test,
            'weight'      => $campaign->weight,
            'node'        => $campaign->node,
            'approved'    => $campaign->approved,
            'status'      => $campaign->status,
        ];
    }

    /**
     * @param \App\Campaign $campaign
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeExchange(Campaign $campaign)
    {

        return $this->collection($campaign->exchanges, new ExchangeTransformer);
    }

    /**
     * @param \App\Campaign $campaign
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeCat(Campaign $campaign)
    {

        return $this->collection($campaign->categories, new CategoryTransformer);
    }

    /**
     * @param \App\Campaign $campaign
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeAdomain(Campaign $campaign)
    {

        return $this->collection($campaign->advertiserDomains, new AdvertiserDomainTransformer);
    }

    /**
     * @param \App\Campaign $campaign
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeBudget(Campaign $campaign)
    {

        return $this->item($campaign->budget ?: new Budget, new BudgetTransformer);
    }

    /**
     * @param \App\Campaign $campaign
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Campaign $campaign)
    {

        return $this->item($campaign->demography ?: new Demography, new DemographyTransformer);
    }

    /**
     * @param \App\Campaign $campaign
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeGeo(Campaign $campaign)
    {

        return $this->collection($campaign->geography ?: new Geography, new GeographyTransformer);
    }

    /**
     * @param \App\Campaign $campaign
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeCreatives(Campaign $campaign)
    {

        return $this->collection($campaign->creatives ?: new Creative, new CreativeTransformer);
    }

    /**
     * @param \App\Campaign $campaign
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeDevice(Campaign $campaign)
    {

        return $this->item($campaign->devices->first() ?: new Device, new DeviceTransformer);
    }
}
