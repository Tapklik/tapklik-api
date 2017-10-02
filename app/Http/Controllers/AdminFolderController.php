<?php namespace App\Http\Controllers;


use App\Account;
use App\Folder;
use App\Transformers\CreativeTransformer;
use App\Transformers\FolderTransformer;
use Illuminate\Http\Response;

class AdminFolderController extends Controller
{
    public function index($uuid)
    {
        try {
            $account = Account::findByUuId($uuid);

            return $this->collection($account->folders, new FolderTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Folders do not exist');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, 'Unknown error', $e->getMessage());
        }
    }

    public function show($accountUuId, $uuid)
    {
        try {
            $folder = Folder::findByUuId($uuid);

            return $this->collection($folder->creatives, new CreativeTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Folders do not exist');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, 'Unknown error', $e->getMessage());
        }
    }
}
