<?php namespace App\Http\Controllers;

use App\Campaign;
use App\Transformers\DeviceTransformer;
use Illuminate\Http\Response;

/**
 * Class CampaignsOsController
 *
 * @package App\Http\Controllers
 */
class CampaignsOsController extends Controller
{

    /**
     * @param $uuid
     *
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function store($uuid)
    {
        try {
            $campaign = Campaign::findByUuId($uuid);

            $operatingSystems = collect(request('os'))->map(function($os) {

                return $os;
            });

            $campaign->deviceOperatingSystems()->sync($operatingSystems);

            return $this->item($campaign, new DeviceTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign '.$uuid.' does not exist.');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Unknown error', $e->getMessage());
        }
    }
}
