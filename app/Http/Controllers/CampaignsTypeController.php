<?php namespace App\Http\Controllers;

use App\Campaign;
use App\DeviceType;
use App\Transformers\DeviceTransformer;
use Illuminate\Http\Response;

class CampaignsTypeController extends Controller
{
    public function store($uuid)
    {

        try {
            $campaign = Campaign::findByUuId($uuid);

            $types = collect(request('types'))->map(function($type) {

                try {

                    $type = DeviceType::findByTypeId($type);

                    return $type->id;
                } catch (ModelNotFoundException $e) {
                    // skip
                }
            });

            $campaign->deviceTypes()->sync($types);

            return $this->item($campaign, new DeviceTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign '.$uuid.' does not exist.');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Unknown error', $e->getMessage());
        }
    }
}
