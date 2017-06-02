<?php namespace App\Transformers;

use App\Category;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class CategoryTransformer extends TransformerAbstract
{

    public function transform(Category $category)
    {

        return $category->code;
    }
}
