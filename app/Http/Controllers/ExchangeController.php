<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Exchange;
use App\Transformers\ExchangeTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class ExchangeController
 *
 * @package App\Http\Controllers
 */
class ExchangeController extends Controller
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
            $exchanges = Exchange::findByCampaignUuId($uuid);

            return $this->collection($exchanges, new ExchangeTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign '.$uuid.' does not exist.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param                           $uuid
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $uuid)
    {

        try {
            $exchange = new Exchange($request->input());

            $campaign = Campaign::findByUuId($uuid);
            $campaign->exchanges()->save($exchange);

            return $this->collection($campaign->exchanges, new ExchangeTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign '.$uuid.' does not exist.');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, 'Unknown Error', $e->getMessage());
        }
    }
}
