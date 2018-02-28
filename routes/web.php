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

        $client = new Google_Client();
	    $client->setAuthConfig(database_path('adx-api-keys.json'));
	    $client->setDeveloperKey('AIzaSyDCqcd4guXzUlFLWl5Y8H9X-KfcWe2mnKE');
	    $client->addScope(Google_Service_AdExchangeBuyer::ADEXCHANGE_BUYER);
        $client->setApplicationName('Creatives verifier');

        $service = new Google_Service_AdExchangeBuyer($client);
        $creative = new Google_Service_AdExchangeBuyer_Creative();

        $creative->setAccountId(244977050);
        $creative->setHTMLSnippet('<iframe src=\'https://104.225.218.101:10015/paint/9cf0882c-1bcc-11e8-b0da-0242ac110002?%%CLICK_URL_ESC%%&ct=http%3A%2F%2Ftapklik.com&preview=1&type=html5\' marginwidth=\'0\' marginheight=\'0\' align=\'top\' scrolling=\'no\' frameborder=\'0\' hspace=\'0\' vspace=\'0\' height=\'250\' width=\'300\'></iframe>');
        $creative->setHeight(250);
        $creative->setWidth(300);
        $creative->setBuyerCreativeId('9cf0882c-1bcc-11e8-b0da-0242ac110002');
        $creative->setClickThroughUrl('http://tapklik.com');

        dd($service->creatives->insert($creative));
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
