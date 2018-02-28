<?php namespace App\Http\Controllers;

use App\Creative;
use App\Transformers\CreativeTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CreativesVerficationController extends Controller
{

	public function store(string $id)
	{

		return response([], Response::HTTP_BAD_REQUEST);
    }

	public function show(string $id)
	{

		return response(['status' => 'Pending verification']);
    }
}
