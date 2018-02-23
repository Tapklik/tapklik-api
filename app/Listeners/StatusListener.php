<?php

namespace App\Listeners;

use App\Campaign;
use App\Events\Backup;
use App\Events\Status;
use Carbon\Carbon;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StatusListener
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
    public function handle(Status $event)
    {
	    $toStart = Campaign::where('start', '>=', Carbon::now())->where(['status' => 'not started'])->get();
	    $toEnd   = Campaign::where('end', '<', Carbon::now())->where(['status' => 'active'])->get();

	    $toStart->each(function($campaign) {
		    $campaign->status = 'active';
		    $campaign->save();
	    });

	    $toEnd->each(function($campaign) {
		    $campaign->status = 'expired';
		    $campaign->save();
	    });
    }
}
