<?php namespace App\Transformers;

use App\Exchange;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class ExchangeTransformer extends TransformerAbstract
{

    public function transform(Exchange $exchange)
    {

        return $exchange->exchange;
    }
}
