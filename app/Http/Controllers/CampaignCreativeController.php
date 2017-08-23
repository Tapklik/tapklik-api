<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Creative;
use App\Transformers\CreativeTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

/**
 * Class CampaignCreativeController
 *
 * @package App\Http\Controllers
 */
class CampaignCreativeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param $uuid
     *
     * @return \Illuminate\Http\Response
     */
    public function index($uuid)
    {
        try {
            $campaign = Campaign::findByUuId($uuid);

            return $this->collection($campaign->creatives, new CreativeTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign '.$uuid.' does not exist.');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Unknown error', $e->getMessage());
        }
    }

    public function store($uuid)
    {
        try {
            $campaign = Campaign::findByUuId($uuid);

            $ids = collect(request('creatives'))->map(function($uid) use ($campaign) {

                try{
                    $creative = Creative::findByUuId($uid);
                    $creative->adm = Creative::generateAdm($campaign->uuid, $uid);
                    $creative->save();
                } catch (ModelNotFoundException $e) {}

                return $creative->id;
            });

            $campaign->creatives()->sync($ids);

            return $this->collection($campaign->creatives, new CreativeTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign '.$uuid.' does not exist.');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Unknown error', $e->getMessage());
        }
    }

}
