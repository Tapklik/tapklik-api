<?php namespace App\Transformers;

use App\Attribute;
use App\Publisher;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class PublisherTransformer extends TransformerAbstract
{

    public function transform(Publisher $publisher)
    {

        return ['id'   => $publisher->_id,
                'site' => $publisher->publisher_site];
    }
}
