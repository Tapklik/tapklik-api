<?php namespace App\Http\Controllers;

use App\Creative;
use App\Transformers\CreativeTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Notification;
use App\Folder;
use App\User;
use App\Notifications\ApproveCreative;
use App\Notifications\RejectCreative;

class CreativesController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param $uuid
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        try {

            $creatives = Creative::findByAccountId($id);

            return $this->collection($creatives, new CreativeTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, $e->getMessage());
        }
    }

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
            $creative_old_status = $creative->status;
            $creative->update($request->input());
            $creative_new_status = $creative->status;
            $creative->save();

            if($creative_old_status != $creative_new_status) {
                $folder = Folder::findById($creative->folder_id);
                $users = User::findByAccountId($folder->account_id);
                if($creative_new_status == 'approved') {
                    Notification::send($users, new ApproveCreative($creative->uuid));
                }
                if($creative_new_status == 'declined') {
                    Notification::send($users, new RejectCreative($creative->uuid));
                }
            }
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
