<?php namespace App\Observers;

use App\User;
use Ramsey\Uuid\Uuid;

/**
 * Class CreativeObserver
 *
 * @package \App\Observers
 */
class UserObserver extends BaseObserver
{

    /**
     * @param \App\User $user
     *
     * @internal param \App\Creative $creative
     */
    public function created(User $user)
    {

        // Set defaults
        $uuid           = self::generateId(6);
        $user->uuid = $uuid;
        $user->save();
    }
}
