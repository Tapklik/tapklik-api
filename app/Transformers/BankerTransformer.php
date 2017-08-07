<?php namespace App\Transformers;

use App\Contracts\BankerInterface;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class BankerTransformer extends TransformerAbstract
{

    /**
     * @param \App\Contracts\BankerInterface $banker
     *
     * @return array
     */
    public function transform(BankerInterface $banker)
    {

        return [
            'id'          => $banker->uuid,
            'debit'       => $banker->debit,
            'credit'      => $banker->credit,
            'timestamp'   => $banker->updated_at->toDateTimeString(),
            'description' => $banker->description,
        ];
    }
}
