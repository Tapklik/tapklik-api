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

    public function transform(AdvertiserDomain $adomain)
    {

        return $adomain->url;
    }
}
