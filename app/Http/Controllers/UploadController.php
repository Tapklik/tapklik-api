<?php namespace App\Http\Controllers;

use App\Creative;
use App\Transformers\CreativeTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tapklik\Uploader\Contracts\AbstractUploader as Uploader;
use Tapklik\Uploader\Exceptions\TapklikUploaderException;
use App\Folder;
use App\Account;

/**
 * Class UploadController
 *
 * @package App\Http\Controllers
 */
class UploadController extends Controller
{

    public function store(Request $request, Uploader $uploader)
    {

        try {
            $folder = Folder::findById($request->input('folder_id'));
            $account = Account::find($folder->account_id);
            $file      = $uploader->move($account->uuid,$request->file('file'));
            $objectUrl = $uploader->save($file);

            if($request->input('nosave')) return response(['error' => false, 'message' => $objectUrl]);

            $creative  = Creative::newCreative(array_merge($request->input(), $objectUrl, (array)$file));

            return $this->item($creative, new CreativeTransformer());
        } catch (TapklikUploaderException $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }

    }
}
