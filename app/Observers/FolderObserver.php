<?php namespace App\Observers;

use App\Folder;
use Ramsey\Uuid\Uuid;

/**
 * Class CreativeObserver
 *
 * @package \App\Observers
 */
class FolderObserver
{

    /**
     * @param \App\Folder $folder
     *
     * @internal param \App\User $user
     */
    public function created(Folder $folder)
    {

        // Set defaults
        $uuid         = Uuid::uuid1();
        $folder->uuid = $uuid->toString();
        $folder->save();
    }
}
