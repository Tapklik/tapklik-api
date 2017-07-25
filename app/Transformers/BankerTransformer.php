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

    public function transform(Banker $banker)
    {

        return [
            'id'     => $banker->uuid,
            'amount' => $banker->amount,
            'debit'  => $banker->debit,
            'credit' => $banker->credit,
            'timestamp' => $banker->updated_at->toDateTimeString()
        ];
    }
}
