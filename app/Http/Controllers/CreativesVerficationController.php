<?php namespace App\Http\Controllers;

use App\Creative;
use App\Transformers\CreativeTransformer;
use Google_Client;
use Google_Service_AdExchangeBuyer;
use Google_Service_AdExchangeBuyer_Creative;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CreativesVerficationController extends Controller
{

	public function store(string $id)
	{
		$client = $this->_getClient();

		$service = new Google_Service_AdExchangeBuyer($client);
		$payload = new Google_Service_AdExchangeBuyer_Creative();

		$payload->setAccountId(env('GOOGLE_EXCHANGE_ACCOUNT_ID'));
		$payload->setHTMLSnippet(request('html.snippet'));
		$payload->setHeight(request('html.height'));
		$payload->setWidth(request('html.width'));
		$payload->setBuyerCreativeId($id);
		$payload->setClickThroughUrl([request('clickThroughUrls')]);
		$payload->setAdvertiserName(request('advertiserName'));

		try {
			$response = $service->creatives->insert($payload);

			return response([
				'error' => false,
				'message' => 'Creative has been sent to approval'
			]);
		} catch (\Exception $e) {
			return $this->error($e->getCode(), $e->getMessage());
		}


		return response([], Response::HTTP_BAD_REQUEST);
    }

	public function show(string $id)
	{
		$client = $this->_getClient();

		$service = new Google_Service_AdExchangeBuyer($client);

		try {
			$result = $service->creatives->get(env('GOOGLE_EXCHANGE_ACCOUNT_ID'), $id);

			return response([
				'status' => $result->getDealsStatus(),
			]);
		} catch (\Exception $e) {
			return $this->error($e->getCode(), $e->getMessage());
		}
    }

    private function _getClient() {
	    $client = new Google_Client();
	    $client->setAuthConfig(database_path(env('GOOGLE_EXCHANGE_CONFIG')));
	    $client->setDeveloperKey(env('GOOGLE_EXCHANGE_DEVELOPER_KEY'));
	    $client->addScope(Google_Service_AdExchangeBuyer::ADEXCHANGE_BUYER);
	    $client->setApplicationName(env('GOOGLE_EXCHANGE_APPLICATION_NAME'));

	    return $client;
    }
}
