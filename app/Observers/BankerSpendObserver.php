<?php namespace App\Observers;

use App\BankerSpend;
use Ramsey\Uuid\Uuid;

/**
 * Class CreativeObserver
 *
 * @package \App\Observers
 */
class BankerSpendObserver
{

    /**
     * @param \App\BankerSpend $banker
     */
    public function created(BankerSpend $banker)
    {

        // Set defaults
        $uuid           = Uuid::uuid1();
        $banker->uuid   = $banker->uuid ?: $uuid->toString();
        $banker->save();
    }
}
