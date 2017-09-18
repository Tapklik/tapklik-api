<?php namespace App\Http\Controllers;

use App\Http\Response\FractalResponse;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class AccountsLogController extends Controller
{
    private $_client = null;

    public function __construct(Request $request, FractalResponse $fractal)
    {
        $this->_client = new Client([
            'base_uri' => 'http://tapklikhq.loggly.com'
        ]);

        parent::__construct($request, $fractal);
    }

    public function index()
    {
        try {
            $log = $this->_client->get('apiv2/events/?rsid=' . $this->_getRsId(), [
                'auth' => [
                    getenv('LOGGLY_USERNAME'),
                    getenv('LOGGLY_PASSWORD'),
                ]
            ]);

            $logEntries = json_decode($log->getBody()->getContents());


            return [
                'data' => $this->_summarizeLog($logEntries->events)
            ];

        } catch (GuzzleException $e) {

            dd($e->getMessage());
        }
    }

    private function _summarizeLog($entries)
    {

        $log = collect($entries)->map(function($entry) {

            return [
                'id'        => $entry->id,
                'timestamp' => $entry->timestamp,
                'log'       => $entry->event->json->message,
                'ip'        => $entry->event->http->clientHost
            ];
        });

        return $log;
    }

    private function _getRsId()
    {
        $lookupTag = 'account-' . $this->getJwtUserClaim('id');

        try {

            $response = $this->_client->get('apiv2/search/?q=tag:' . $lookupTag . '&size=10', [
                'auth' => [
                    getenv('LOGGLY_USERNAME'),
                    getenv('LOGGLY_PASSWORD'),
                ]
            ]);

            $object = json_decode($response->getBody()->getContents());

            return $object->rsid->id;
        } catch (GuzzleException $e) {

            dd($e->getMessage());
        }
    }
}
