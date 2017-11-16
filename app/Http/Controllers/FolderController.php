<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Transformers\CreativeTransformer;
use App\Transformers\FolderTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class FolderController
 *
 * @package App\Http\Controllers
 */
class FolderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $folders = Folder::findByAccountId($this->getJwtUserClaim('accountId'));

            return $this->collection($folders, new FolderTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Folders do not exist');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, 'Unknown error', $e->getMessage());
        }
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
        try {
            $folder = Folder::create([
                'name'       => request('name'),
                'account_id' => $this->getJwtUserClaim('accountId'),
                'status'     => request('status')
            ]);

            return $this->item($folder, new FolderTransformer());
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Folders do not exist');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, 'Unknown error', $e->getMessage());
        }
    }

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

            $folder = Folder::findByUuId($uuid);

            return $this->collection($folder->creatives, new CreativeTransformer);
        }  catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Folders ' . $uuid . ' does not exist.');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, 'Unknown error', $e->getMessage());
        }
    }

    public function delete($uuid)
    {
        try {
            $folder = Folder::findByUuId($uuid);

            if($folder->creatives->count() > 0) return $this->error(Response::HTTP_BAD_REQUEST, 'Folder is not empty');

            $folder->delete();

            return response([], Response::HTTP_NO_CONTENT);

        }  catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Folders ' . $uuid . ' does not exist.');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, 'Unknown error', $e->getMessage());
        }
    }
}
