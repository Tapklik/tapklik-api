<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Demography;
use App\Transformers\DemographyTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class DemographyController extends Controller
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

            return $this->item($campaign->demography ?: factory(Demography::class)->create([
                'campaign_id' => $campaign->id
            ]), new
            DemographyTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign ' . $uuid . ' does not exist.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Demography  $demography
     * @return \Illuminate\Http\Response
     */
    public function show(Demography $demography)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Demography  $demography
     * @return \Illuminate\Http\Response
     */
    public function edit(Demography $demography)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Demography  $demography
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Demography $demography)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Demography  $demography
     * @return \Illuminate\Http\Response
     */
    public function destroy(Demography $demography)
    {
        //
    }
}
