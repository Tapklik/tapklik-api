<?php namespace App\Http\Controllers;

use App\Creative;
use App\Transformers\CreativeTransformer;
use Illuminate\Http\Request;
use Tapklik\Uploader\Contracts\AbstractUploader;

/**
 * Class UploadController
 *
 * @package App\Http\Controllers
 */
class UploadController extends Controller
{

    public function store(Request $request, AbstractUploader $uploader)
    {
        $file      = $uploader->move($request->file('file'));
        $objectUrl = $uploader->save($file);
        $creative  = Creative::newCreative(array_merge($request->input(), $objectUrl, (array)$file));

        return $this->item($creative, new CreativeTransformer());
    }
}
