<?php namespace App\Transformers;

use App\Budget;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class BudgetTransformer extends TransformerAbstract
{

    /**
     * @param \App\Budget $budget
     *
     * @return array
     */
    public function transform(Budget $budget)
    {

        return [
            'type'   => $budget->type,
            'amount' => $budget->amount,
            'pacing' => $budget->pacing,
        ];
    }
}
