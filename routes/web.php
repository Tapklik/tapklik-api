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

use App\Campaign;
use App\Creative;
use Illuminate\Http\UploadedFile;
use Tapklik\Uploader\Drivers\ZipDriver;
use Tapklik\Uploader\Service;

Route::get(
    '/test',
    function () {

        $cr = Creative::findOrFail(1);
        $campaign = Campaign::findOrFail(1);

        $adm = Creative::generateAdm($campaign->uuid,$cr->uuid, 'js');

        echo $adm;
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
