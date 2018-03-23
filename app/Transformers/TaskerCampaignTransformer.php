<?php namespace App\Transformers;

use App\Campaign;
use League\Fractal\TransformerAbstract;


class TaskerCampaignTransformer extends TransformerAbstract
{

    public function transform(Campaign $campaign)
    {

        return [
        	    'id' => $campaign->uuid,
            'name' => $campaign->name,
	        'users' => $campaign->account->users
        ];
    }
}
