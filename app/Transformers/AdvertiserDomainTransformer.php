<?php namespace App\Transformers;

use App\AdvertiserDomain;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class AdvertiserDomainTransformer extends TransformerAbstract
{

    /**
     * @param \App\AdvertiserDomain $adomain
     *
     * @return mixed
     */
    public function transform(AdvertiserDomain $adomain)
    {

        return $adomain->url;
    }
}
