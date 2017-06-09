<?php namespace App\Transformers;

use App\Btype;
use App\Exchange;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class BtypeTransformer extends TransformerAbstract
{

    /**
     * @param \App\Btype $btype
     *
     * @return mixed
     */
    public function transform(Btype $btype)
    {

        return $btype->type;
    }
}
