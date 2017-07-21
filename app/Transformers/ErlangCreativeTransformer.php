<?php namespace App\Transformers;


use App\Creative;
use League\Fractal\TransformerAbstract;

/**
 * Class CampaignTransformer
 *
 * @package \app\Transformers
 */
class ErlangCreativeTransformer extends TransformerAbstract
{
    //    protected $defaultIncludes = [ 'device'];

    /**
     * @param \App\Campaign $campaign
     *
     * @return array
     */
    public function transform(Creative $creative)
    {

        return [
            'id' => $creative->id
        ];
    }



}
