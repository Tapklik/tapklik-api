<?php namespace App\Observers;

use App\Banker;
use Ramsey\Uuid\Uuid;

/**
 * Class CreativeObserver
 *
 * @package \App\Observers
 */
class BankerObserver
{

    /**
     *
     * @internal param \App\Creative $creative
     *
     * @param \App\Banker $banker
     */
    public function created(Banker $banker)
    {

        // Set defaults
        $uuid           = Uuid::uuid1();
        $banker->uuid   = $banker->uuid ?: $uuid->toString();
        $banker->save();
    }
}
