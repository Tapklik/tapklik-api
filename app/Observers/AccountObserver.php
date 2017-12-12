<?php namespace App\Observers;

use App\Account;

/**
 * Class AccountObserver
 *
 * @package \App\Observers
 */
class AccountObserver extends BaseObserver
{

    /**
     * @param \App\Account $account
     */
    public function created(Account $account)
    {
        // Set defaults
        $uuid          = self::generateId(6);
        $account->uuid = $uuid;
        $account->save();
    }
}
