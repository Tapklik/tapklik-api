<?php namespace App\Observers;

use App\Budget;
use App\Campaign;

/**
 * Class CampaignObserver
 *
 * @package \App\Observers
 */
class CampaignObserver
{

    public function created(Campaign $campaign)
    {

        // Set defaults
        $uuid                  = \Ramsey\Uuid\Uuid::uuid1();
        $campaign->uuid        = $uuid->toString();
        $campaign->description = $campaign->description ?: '';
        $campaign->save();

        // Set default budget
        factory(Budget::class)->create(
            [
                'campaign_id' => $campaign->id,
            ]
        );

        // Set user
        // Should be left empty
//        factory(Demography::class)->create(
//            [
//                'campaign_id' => $campaign->id,
//            ]
//        );
    }
}
