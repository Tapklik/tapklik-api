<?php namespace App\Transformers;

use App\Geography;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class GeographyTransformer extends TransformerAbstract
{

    /**
     * @param \App\Geography $geography
     *
     * @return array
     */
    public function transform(Geography $geography)
    {

        return [
            'country'     => $geography->country,
            'city'        => $geography->city,
            'region'      => $geography->region,
            'region_name' => $geography->region_name,
        ];
    }
}
