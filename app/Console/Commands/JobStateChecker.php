<?php

namespace App\Console\Commands;

use App\Campaign;
use Carbon\Carbon;
use Illuminate\Console\Command;

class JobStateChecker extends Command
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
