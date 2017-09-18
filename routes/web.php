<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\LogglyHandler;
use Monolog\Handler\SyslogUdpHandler;
use Monolog\Logger;

Route::get(
    '/',
    function () {


        date_default_timezone_set("UTC");



        $log = new Logger('appName');
        $log->pushHandler(new LogglyHandler('2b6bf428-f0f2-4f6e-8d05-7ee18bf67a2a/tag/monolog', Logger::INFO));
        $r = $log->addWarning('test logs to loggly');
        dd($r);


        return view('welcome');
    }
);
