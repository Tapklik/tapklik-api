<?php namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Http\Requests\MailRequest;
use Aws\Ses\Exception\SesException;
use Aws\Ses\SesClient;
use Illuminate\Http\Response;

class MailController extends Controller
{

    public function index() {

        $ses = new SesClient([
            'version'     => env('SES_VERSION'),
            'region'      => env('SES_REGION'),
            'credentials' => [
                'key'    => env('SES_KEY'),
                'secret' => env('SES_SECRET')
            ]
        ]);

//        dd(request('message/'));
        try {
            $result = $ses->sendEmail([
                'Source' => 'robot@tapklik.com',
                'Destination' => [
                    'ToAddresses' => [request('to')]
                ],
                'Message' => [
                    'Subject' => [
                        'Data' => request('subject')
                    ],
                    'Body' => [
                        'Text' => [
                            'Data' => request('message')
                        ]
                    ],
                ],
            ]);

            return response(['data' => [
                'id' => $result->get('MessageId')]
            ]);
        } catch (SesException $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, 'Error sending an email', $e->getMessage());
        }

    }
}
