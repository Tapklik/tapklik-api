<?php namespace App\Http\Controllers;


use Illuminate\Http\Response;

/**
 * Class HealthCheckController
 *
 * @package App\Http\Controllers
 */
class HealthCheckController extends Controller
{

    /**
     * @return json
     */
    public function index()
    {
        return response(['status' => 'OK'], Response::HTTP_OK);
    }
}
