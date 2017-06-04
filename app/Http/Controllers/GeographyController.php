<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Geography;
use App\Transformers\GeographyTransformer;
use Illuminate\Http\Request;

class GeographyController extends Controller
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

            return $this->collection($campaign->geography, new GeographyTransformer());
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign '.$uuid.' does not exist.');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Unknown error', $e->getMessage());
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
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Geography $geography
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Geography $geography)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Geography $geography
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Geography $geography)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Geography           $geography
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Geography $geography)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Geography $geography
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Geography $geography)
    {
        //
    }
}
