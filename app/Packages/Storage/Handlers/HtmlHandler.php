<?php namespace Tapklik\Storage\Handlers;

use Symfony\Component\HttpFoundation\File\File;
use Tapklik\Storage\Contracts\AbstractStorageAdapter;
use Tapklik\Storage\Contracts\FileHandlerInterface;

class HtmlHandler implements FileHandlerInterface
{

    public function handle(File $file, AbstractStorageAdapter $uploader) : Array
    {

        try {
            $content = file_get_contents($file->getPathname());

            $result = $uploader->getStorageDriver()
	            ->upload(
	            	    getenv('AWS_BUCKET'),
		            \Request::input('path') . '/b/' . \Request::input('name'),
		            $content,
		            'public-read'
	            );

                $uploadedFileLocation = env('CREATIVES_PATH') . '/b/' . $file->getFilename();


            return ['iurl' => $uploadedFileLocation];
        } catch (S3Exception $e) {

            throw new TapklikUploaderException($e->getMessage(), $e->getCode());
        }
    }
}
