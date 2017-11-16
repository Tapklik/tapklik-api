<?php namespace App\Http\Controllers;

use App\Creative;
use App\Transformers\CreativeTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
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

    public function update(Request $request, $uuid)
    {
        try {
            $creative = Creative::findByUuId($uuid);
            $creative->update($request->input());
            $creative->save();

            return $this->item($creative, new CreativeTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Creative not found');
        }
    }

    public function delete($uuid) {

        try {
            $creative = Creative::findByUuId($uuid);

            $creative->delete();

            return response([], Response::HTTP_NO_CONTENT);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Creative not found');
        }
    }
}
