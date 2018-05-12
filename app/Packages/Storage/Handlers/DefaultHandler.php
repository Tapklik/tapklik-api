<?php namespace Tapklik\Storage\Handlers;

use Symfony\Component\HttpFoundation\File\File;
use Tapklik\Storage\Contracts\AbstractStorageAdapter;
use Tapklik\Storage\Contracts\FileHandlerInterface;

/**
 * Class ZipHandler
 *
 * @package \\${NAMESPACE}
 */
class DefaultHandler implements FileHandlerInterface
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
            $content = file_get_contents($file->getPathname());
            $result = $uploader->getStorageDriver()->upload(getenv('AWS_BUCKET'), 'creatives/b/' . $file->getFilename(),
                $content, 'public-read');

            $uploadedFileLocation = env('CREATIVES_PATH') . '/b/' . $file->getFilename();

            return ['iurl' => $uploadedFileLocation];
        } catch (S3Exception $e) {

            throw new TapklikUploaderException($e->getMessage(), $e->getCode());
        }
    }
}
