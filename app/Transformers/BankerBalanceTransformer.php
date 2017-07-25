<?php namespace App\Transformers;

use Illuminate\Database\Eloquent\Model;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class BankerBalanceTransformer extends TransformerAbstract
{

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return array
     */
    public function transform(Model $model)
    {

        return [
            'balance' => $model->banker()->sum('credit') - $model->banker()->sum('debit')
        ];
    }
}
