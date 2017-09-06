<?php

namespace App\Providers;

use DateTime;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Support\ServiceProvider;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\SyslogUdpHandler;
use Psr\Log\LoggerInterface;

class MonologHandlerServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @param \Illuminate\Contracts\Logging\Log $log
     *
     * @return void
     */
    public function boot(Log $log)
    {
        $monolog = $log->getMonolog();

        $hostname = gethostname();
        $sysLogHandler = new SyslogUdpHandler("logsene-syslog-receiver.eu.sematext.com");
        $lineFormatter = new LineFormatter("%datetime% ${hostname} 1adf496b-b3a2-4bb0-901f-2858ed8d5094 - ID47 %message%", DateTime::RFC3339);
        $sysLogHandler->setFormatter($lineFormatter);
        $monolog->pushHandler($sysLogHandler);

        $monolog->addDebug('Wtf');
        $monolog->debug('Wtf');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
