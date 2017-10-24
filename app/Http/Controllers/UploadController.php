<?php namespace App\Http\Controllers;

use App\Creative;
use App\Transformers\CreativeTransformer;
use Aws\S3\S3Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class UploadController
 *
 * @package App\Http\Controllers
 */
class UploadController extends Controller
{

    public function store(Request $request)
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

            $s3Url = $this->_uploadToS3($object);
            $creative->iurl = $s3Url;
            $creative->save();

            $actionToLog = sprintf('%s uploaded creative ID#%s',
                $this->getJwtUserClaim('name'),
                $creative->uuid
            );

            $this->logActionToLoggerProvider($actionToLog);

            return $this->item($creative, new CreativeTransformer);
        } else {
            return $this->error(Response::HTTP_BAD_REQUEST, 'Something went wrong');
        }
    }

    private function _uploadToS3($file)
    {
        try {
            $client = S3Client::factory(
                [
                    'region' => getenv('AWS_REGION'),
                    'version' => '2006-03-01',
                    'credentials' => [
                        'key' => getenv('AWS_ACCESS_KEY'),
                        'secret' => getenv('AWS_SECRET_KEY')
                    ]
                ]);

            try {
                $content = file_get_contents($file->getPathname());
                $result = $client->upload(getenv('AWS_BUCKET'), 'creatives/' . $file->getFilename(), $content, 'public-read');

                return $result->get('ObjectURL');
            } catch (\Exception $e) {
                echo $e->getMessage();
                die;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            die;
        }

    }

    private function _makeCreative($object, $config = [])
    {

        $creative = new Creative(
            [
                 'name'       => request('name') ?: md5($object->getFileName()),
                 'expdir'     => request('expdir') ?: 0,
                 'adm'        => '',
                 'ctrurl'     => request('ctrurl'),
                 'class'      => request('class'),
                 'iurl'       => $object->getFileName(),
                 'type'       => request('type'),
                 'h'          => request('h'),
                 'w'          => request('w'),
                 'folder_id'  => $config['folder_id'],
                 'responsive' => request('responsive'),
                 'thumb'      => request('thumb')
            ]
        );

        return $creative;
    }
}
