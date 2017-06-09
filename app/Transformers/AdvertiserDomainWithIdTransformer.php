<?php namespace App\Transformers;

use App\AdvertiserDomain;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class AdvertiserDomainWithIdTransformer extends TransformerAbstract
{

    /**
     * @param \App\AdvertiserDomain $adomain
     *
     * @return array
     */
    public function transform(AdvertiserDomain $adomain)
    {

        return [
            'id'  => $adomain->id,
            'url' => $adomain->url
        ];
    }
}
