<?php namespace App\Observers;

use App\Budget;
use App\Campaign;
use App\Creative;

/**
 * Class CampaignObserver
 *
 * @package \App\Observers
 */
class CreativeObserver
{

    public function created(Creative $creative)
    {

        // Set defaults
        $uuid           = \Ramsey\Uuid\Uuid::uuid1();
        $creative->uuid = $uuid->toString();
        $creative->save();
    }
}
