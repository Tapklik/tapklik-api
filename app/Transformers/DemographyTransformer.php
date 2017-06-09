<?php namespace App\Transformers;

use App\Demography;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class DemographyTransformer extends TransformerAbstract
{

    /**
     * @param \App\Demography $user
     *
     * @return array
     */
    public function transform(Demography $user)
    {

        return [
            'gender' => $user->gender,
            'age'    => [
                'min' => $user->from_age,
                'max' => $user->to_age,
            ],
        ];
    }
}
