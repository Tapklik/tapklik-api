<?php namespace App\Transformers;

use App\Category;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class CoreCategoryTransformer extends TransformerAbstract
{

    /**
     * @param \App\Category $category
     *
     * @return mixed
     */
    public function transform(Category $category)
    {

        return [
        	    'code' => $category->code,
	        'name' => $category->name
        ];
    }
}
