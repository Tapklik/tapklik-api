<?php namespace Tapklik\Storage\Handlers;

use Symfony\Component\HttpFoundation\File\File;
use Tapklik\Storage\Contracts\AbstractStorageAdapter;
use Tapklik\Storage\Contracts\FileHandlerInterface;
use Tapklik\Uploader\Contracts\UploaderInterface;

/**
 * Class ZipHandler
 *
 * @package \\${NAMESPACE}
 */
class ZipHandler implements FileHandlerInterface
{

    /**
     * @param \Symfony\Component\HttpFoundation\File\File       $file
     *
     * @param \Tapklik\Storage\Contracts\AbstractStorageAdapter $uploader
     *
     * @return \Tapklik\Storage\Handlers\Array
     */
    public function handle(File $file, AbstractStorageAdapter $uploader) : Array
    {

        try {
            $uploader->getStorageDriver()->uploadDirectory(
                public_path(str_replace('.zip', '', $file->getPathname())),
                getenv('AWS_BUCKET'),
                'creatives/html5/' . $file->getFilename()
            );


            $localZipFileLocation = url('trunk' . str_replace('./trunk', '', $file->getPathname()));
            $uploadedFileLocation = 'https://cdn.tapklik.com/creatives/html5/' . $file->getFilename();

            return [
            	    'iurl' => $uploadedFileLocation . '/index.html',
                'asset' => $localZipFileLocation,
                'thumb' => $uploadedFileLocation . '/index.jpg'
            ];
        } catch (S3Exception $e) {

            throw new TapklikUploaderException($e->getMessage(), $e->getCode());
        }
    }
}
