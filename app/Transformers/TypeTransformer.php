<?php namespace App\Transformers;

use App\Btype;
use App\Exchange;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class TypeTransformer extends TransformerAbstract
{

    /**
     * @param \App\Btype $btype
     *
     * @return mixed
     */
    public function transform(type $type)
    {

        return $type->type;
    }
}
