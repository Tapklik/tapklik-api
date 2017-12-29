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

use Illuminate\Http\UploadedFile;
use Tapklik\Uploader\Drivers\ZipDriver;
use Tapklik\Uploader\Service;

Route::get(
    '/test',
    function () {

        $file     = new UploadedFile('../tests/data/tapklik.zip', 'tapklik.zip');
        $driver   = new ZipDriver($file, env('UPLOAD_DIR'));
        $storage  = new Tapklik\Storage\Adapters\S3StorageAdapter();
        $uploader = new Service($driver, $storage);

        dd($uploader->move());
    }
);

Route::get(
    '/',
    function () {

        return response()->json(
            ['error' => ['code'    => \Illuminate\Http\Response::HTTP_EXPECTATION_FAILED,
                         'message' => 'Nothing here',
                         'details' => 'Expectation failed',
                         'request' => '']]
        );
    }
);
