<?php namespace App\Transformers;

use App\Attribute;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class AttributeTransformer extends TransformerAbstract
{

    public function transform(Attribute $attribute)
    {

        return $attribute->type;
    }
}
