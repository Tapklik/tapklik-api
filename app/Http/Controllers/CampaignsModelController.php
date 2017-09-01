<?php namespace App\Http\Controllers;

use App\Campaign;
use Illuminate\Http\Response;

class CampaignsModelController extends Controller
{
    public function store($uuid)
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
}
