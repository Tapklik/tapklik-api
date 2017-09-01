<?php namespace App\Http\Controllers;

use App\Campaign;
use App\Geography;
use App\Transformers\GeographyTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class GeographyController
 *
 * @package App\Http\Controllers
 */
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
     * Store a newly created resource in storage.
     *
     * @param $uuid
     *
     * @return \Illuminate\Http\Response
     */
    public function store($uuid)
    {
        try {
            $campaign = Campaign::findByUuId($uuid);

            $geographyIds = collect(request('geo'))->each(function($geo) {
                return $geo;
            });

            $campaign->geography()->sync($geographyIds);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign '.$uuid.' does not exist.');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Unknown error', $e->getMessage());
        }
    }
}
