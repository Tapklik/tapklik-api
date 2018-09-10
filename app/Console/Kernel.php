<?php

namespace App\Console;

use App\Console\Commands\CampaignStateChecker;
use App\Console\Commands\NotifyNearing;
use App\Console\Commands\Jwt;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;
use Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Jwt::class,
        CampaignStateChecker::class,
        NotifyNearing::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('job')->everyMinute();
        $schedule->command('notify_nearing')->daily()->at('07:00')->timezone('UTC');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
