<?php

namespace App\Listeners;

use App\Events\Backup;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BackupListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  BackupListener  $event
     * @return void
     */
    public function handle(Backup $event)
    {

    }
}
