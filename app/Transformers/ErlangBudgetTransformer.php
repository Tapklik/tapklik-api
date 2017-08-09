<?php namespace App\Transformers;


use App\Budget;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class ErlangBudgetTransformer extends TransformerAbstract
{

    // protected $defaultIncludes = [ 'attr'];


    /**
     * @param \App\Campaign $campaign
     *
     * @return array
     */
    public function transform(Budget $budget)
    {

        return [
            'type'   => $budget->type,
            'amount'  => $budget->amount,
            'pacing'   => $budget->pacing,
        ];
    }

    // public function includeAttr(Creative $creative)
    //  {
    //      return $this->collection($creative->attributes, new AttrTransformer);
    //  }

}
