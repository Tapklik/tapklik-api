<?php namespace App\Observers;

use App\Budget;
use App\Campaign;

/**
 * Class CampaignObserver
 *
 * @package \App\Observers
 */
class CampaignObserver extends BaseObserver
{

    public function created(Campaign $campaign)
    {
        // Set defaults
        $uuid                  = self::generateId(10);
        $campaign->uuid        = $uuid;
        $campaign->description = $campaign->description ?: '';
        $campaign->save();

        // Set default budget
        factory(Budget::class)->create(
            [
                'campaign_id' => $campaign->id,
            ]
        );
    }
}
