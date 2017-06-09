<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Transformers\CreativeTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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

}
