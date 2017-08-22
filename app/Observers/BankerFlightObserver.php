<?php namespace App\Observers;

use App\BankerFlight;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Uuid;

/**
 * Class CreativeObserver
 *
 * @package \App\Observers
 */
class BankerFlightObserver
{

    /**
     * @param \App\BankerFlight $banker
     */
    public function created(BankerFlight $banker)
    {

        Log::info($banker->toJson());

        // Set defaults
        $uuid           = Uuid::uuid1();
        $banker->uuid   = $banker->uuid ?: $uuid->toString();
        $banker->save();
    }
}
