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
            'id'           => $geography->id,
            'key'          => $geography->key,
            'country_iso2' => $geography->country_iso2,
            'country_name' => $geography->country_name,
            'country'      => $geography->country,
            'city'         => $geography->city,
            'region'       => $geography->region,
            'region_name'  => $geography->region_name,
            'comment'      => $geography->comment,
        ];
    }
}
