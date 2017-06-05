<?php namespace App\Observers;

use App\User;
use Ramsey\Uuid\Uuid;

/**
 * Class CreativeObserver
 *
 * @package \App\Observers
 */
class UserObserver
{

    /**
     * @param \App\User $user
     *
     * @internal param \App\Creative $creative
     */
    public function created(User $user)
    {

        // Set defaults
        $uuid           = Uuid::uuid1();
        $user->uuid = $uuid->toString();
        $user->save();
    }
}
