<?php namespace App\Transformers;

use App\Banker;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class BankerTransformer extends TransformerAbstract
{

    /**
     * @param \App\Banker $banker
     *
     * @return array
     */
    public function transform(Banker $banker)
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
