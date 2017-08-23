<?php namespace App\Http\Controllers;

use App\Creative;
use App\Transformers\CreativeTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UploadController extends Controller
{

    public function upload(Request $request)
    {

        if ( !$request->hasFile('file'))
            $this->error(Response::HTTP_BAD_REQUEST, 'You need to provide a file');

        $file = $request->file('file');


        if ($object = $file->move(
            env('UPLOAD_DIR'),
            sha1($file->getFilename().time()).'.'.$file->getClientOriginalExtension()
        )) {

            $creative = $this->_makeCreative($object, $request->input());

            $creative->save();

            return $this->item($creative, new CreativeTransformer);
        } else {

            return $this->error(Response::HTTP_BAD_REQUEST, 'Something went wrong');
        }
    }

    private function _makeCreative($object, $config = [])
    {

        $creative = new Creative(
            ['name'      => request('name') ?: md5($object->getFileName()),
             'expdir'    => request('expdir') ?: 0,
             'adm'       => '',
             'ctrurl'    => request('ctrurl'),
             'class'     => request('class'),
             'iurl'      => $object->getFileName(),
             'type'      => request('type'),
             'h'         => request('h'),
             'w'         => request('w'),
             'folder_id' => $config['folder_id']]
        );

        return $creative;
    }
}
