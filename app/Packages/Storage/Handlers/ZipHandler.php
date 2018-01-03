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
                'creatives/' . $file->getFilename()
            );


            $localZipFileLocation = url('trunk' . str_replace('./trunk', '', $file->getPathname()));

            return ['iurl' => 'https://s3-us-west-2.amazonaws.com/comtapklik/creatives/html5/' . $file->getFilename()
                . '/index.html', 'asset' => $localZipFileLocation, 'thumb' => 'https://placehold.it/120x120'];
        } catch (S3Exception $e) {

            throw new TapklikUploaderException($e->getMessage(), $e->getCode());
        }
    }
}
