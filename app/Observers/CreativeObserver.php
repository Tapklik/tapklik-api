<?php namespace App\Observers;

use App\Creative;

/**
 * Class CreativeObserver
 *
 * @package \App\Observers
 */
class CreativeObserver extends BaseObserver
{

    /**
     * @param \App\Creative $creative
     */
    public function created(Creative $creative)
    {

        // Set defaults
        $uuid           = self::generateId(6);
        $creative->uuid = $uuid;
        $creative->save();
    }
}
