<?php

namespace App\Http\Controllers;

use App\AdvertiserDomain;
use App\Campaign;
use App\Transformers\AdvertiserDomainTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class AdvertiserDomainController
 *
 * @package App\Http\Controllers
 */
class AdvertiserDomainController extends Controller
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
            $advertiserDomains = AdvertiserDomain::findByCampaignUuId($uuid);

            return $this->collection($advertiserDomains, new AdvertiserDomainTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign ' . $uuid . ' does not exist.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param $uuid
     *
     * @return \Illuminate\Http\Response
     * @internal param \Illuminate\Http\Request $request
     */
    public function store($uuid)
    {
        try {
            $advertiserDomain = (new AdvertiserDomain())->fill(request('url'));
            $campaign         = Campaign::findByUuId($uuid);

            AdvertiserDomain::deleteForCampaignId($campaign->id);

            $campaign->advertiserDomains()->save($advertiserDomain);

            return $this->collection($campaign->advertiserDomains, new AdvertiserDomainTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign ' . $uuid . ' does not exist.');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, 'Unknown Error', $e->getMessage());
        }
    }
}
