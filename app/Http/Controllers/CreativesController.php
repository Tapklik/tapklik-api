<?php namespace App\Http\Controllers;

use App\Creative;
use App\Transformers\CreativeTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class CreativesController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param $uuid
     *
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        try {
            $creative = Creative::findByUuId($uuid);

            return $this->item($creative, new CreativeTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Creative not found');
        }

    }
}
