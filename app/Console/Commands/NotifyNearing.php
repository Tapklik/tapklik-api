<?php

namespace App\Console\Commands;

use App\Campaign;
use App\User;
use App\Account;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Notification;
use Log;

class NotifyNearing extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify_nearing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notifies when a campaign is close to expiring or starting';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // 1. Campaign that is over is expired (timezone from account)
        // 2. Campaign where start date is less than now is started
        // 3. Left exactly 2 and a half days send a notifications
        // 4. Notifications for all
        Log::info('Testing notify nearing');
        $campaigns = Campaign::all();
        $campaigns->each(function($campaign) {
            $dt = \Carbon\Carbon::now();
            $timezone = Account::find($campaign->account_id)->timezone;
            $dt->setTimeZone($timezone);
            $users = User::findByAccountId($campaign->account_id);
            if($dt->diffInDays($campaign->end) == 2) {
                Notification::send($users, new NearingCampaignEnd($campaign->uuid, 2));
            }
        });
        
    }
}
