<?php

namespace App\Console\Commands;

use App\Campaign;
use App\Account;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Log;

class CampaignStateChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stops passed campaigns and starts due campaigns.';

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
        $campaigns = Campaign::all();
        $campaigns->each(function($campaign) {
            $dt = \Carbon\Carbon::now();
            $timezone = Account::find($campaign->account_id)->timezone;
            $dt->setTimeZone($timezone);
            if($campaign->start < $dt && $campaign->status == 'not started') {
                $campaign->status = 'active';
                $campaign->save();
            }
            if($campaign->end < $dt && $campaign->status == 'active') {
                $campaign->status = 'expired';
                $campaign->save();                
            }
        });
    }
}
