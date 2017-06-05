<?php namespace App\Observers;

use App\Account;
use Ramsey\Uuid\Uuid;

/**
 * Class AccountObserver
 *
 * @package \App\Observers
 */
class AccountObserver
{

    /**
     * @param \App\Account $account
     */
    public function created(Account $account)
    {

        // Set defaults
        $uuid          = Uuid::uuid1();
        $account->uuid = $uuid->toString();
        $account->save();
    }
}
