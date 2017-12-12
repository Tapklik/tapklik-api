<?php namespace App\Observers;

use App\Creative;
use Ramsey\Uuid\Uuid;

/**
 * Class CreativeObserver
 *
 * @package \App\Observers
 */
class CreativeObserver
{

    /**
     * @param \App\Creative $creative
     */
    public function created(Creative $creative)
    {

        // Set defaults
        $uuid           = Uuid::uuid1();
        $creative->uuid = $uuid->toString();
        $creative->save();
    }
}
