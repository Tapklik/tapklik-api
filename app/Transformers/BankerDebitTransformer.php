<?php namespace App\Transformers;

use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class BankerDebitTransformer extends TransformerAbstract
{

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return array
     */
    public function transform(Model $model)
    {

        return [
            'debit' => (int) $model->banker()->sum('debit')
        ];
    }
}
