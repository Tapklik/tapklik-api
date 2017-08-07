<?php namespace App\Observers;

use App\BankerMain;
use Ramsey\Uuid\Uuid;

/**
 * Class CreativeObserver
 *
 * @package \App\Observers
 */
class BankerMainObserver
{

    /**
     * @param \App\BankerMain $banker
     */
    public function created(BankerMain $banker)
    {

        // Set defaults
        $uuid           = Uuid::uuid1();
        $banker->uuid   = $banker->uuid ?: $uuid->toString();
        $banker->save();
    }
}
