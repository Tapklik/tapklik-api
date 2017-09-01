<?php namespace App\Http\Controllers;


use Illuminate\Http\Response;

class HealthCheckController extends Controller
{
    public function index()
    {
        return response(['status' => 'OK'], Response::HTTP_OK);
    }
}
