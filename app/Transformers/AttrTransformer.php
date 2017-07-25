<?php namespace App\Transformers;

use App\Attribute;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class AttrTransformer extends TransformerAbstract
{

    /**
     * @param \App\Attribute $attribute
     *
     * @return mixed
     * @internal param \App\Attribute $attr
     *
     */
    public function transform(Attribute $attribute)
    {

        return $attribute->attr;
    }
}
