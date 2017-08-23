<?php namespace App\Http\Controllers;


use App\Campaign;
use App\DeviceModel;
use App\DeviceOs;
use App\DeviceType;
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

    public function storeType($uuid)
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

    public function storeModel($uuid)
    {
        try {
            $campaign = Campaign::findByUuId($uuid);

            $models = collect(request('models'))->map(function($model) {

                return $model;
            });

            $campaign->deviceModels()->sync($models);

            return $this->item($campaign, new DeviceTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign '.$uuid.' does not exist.');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Unknown error', $e->getMessage());
        }
    }

    public function storeOs($uuid)
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
