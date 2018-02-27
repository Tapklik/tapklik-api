<?php namespace App\Http\Controllers;

use App\Creative;
use App\Transformers\CreativeTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Tapklik\Uploader\Contracts\AbstractUploader as Uploader;
use Tapklik\Uploader\Exceptions\TapklikUploaderException;

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
            $file      = $uploader->move($request->file('file'));
            $objectUrl = $uploader->save($file);

            if($request->input('nosave')) return response(['error' => false, 'message' => $objectUrl]);

            $creative  = Creative::newCreative(array_merge($request->input(), $objectUrl, (array)$file));

            return $this->item($creative, new CreativeTransformer());
        } catch (TapklikUploaderException $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }

    }
}
