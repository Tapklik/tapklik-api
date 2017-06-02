<?php namespace App\Transformers;

use App\Creative;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class CreativeTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['btype', 'attr'];

    public function transform(Creative $creative)
    {

        return [
            'id'     => $creative->uuid,
            'expdir'   => $creative->expdir,
            'adm'      => $creative->adm,
            'ctrurl'   => $creative->ctrurl,
            'iurl'     => $creative->iurl,
            'pos'      => $creative->pos,
            'approved' => $creative->status,
        ];
    }

    public function includeBtype(Creative $creative)
    {
        return $this->collection($creative->btypes, new BtypeTransformer);
    }

    public function includeAttr(Creative $creative)
    {
        return $this->collection($creative->attributes, new AttributeTransformer);
    }
}
