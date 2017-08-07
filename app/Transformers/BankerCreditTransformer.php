<?php namespace App\Transformers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class BankerCreditTransformer extends TransformerAbstract
{

    /**
     * @param \Illuminate\Database\Eloquent\Model $model
     *
     * @return array
     */
    public function transform(Model $model)
    {
        $relationship = $this->_getRelationship();

        return [
            'credit' => (int) $model->{$relationship}()->sum('credit')
        ];
    }

    private function _getRelationship()
    {
        return ucfirst(strtolower(Request::segment(5)));
    }
}
