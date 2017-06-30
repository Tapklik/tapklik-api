<?php namespace App\Http\Controllers;


use App\Campaign;
use App\Transformers\DeviceTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class CampaignDeviceController extends Controller
{
    public function index($uuid)
    {
        try {
            $campaign = Campaign::findByUuId($uuid);

            return $this->item($campaign, new DeviceTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign '.$uuid.' does not exist.');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Unknown error', $e->getMessage());
        }
    }
}
