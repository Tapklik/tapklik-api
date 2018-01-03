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
            $result = $uploader->getStorageDriver()->upload(getenv('AWS_BUCKET'), 'creatives/' . $file->getFilename(),
                $content, 'public-read');

            return ['iurl' => $result->get('ObjectURL')];
        } catch (S3Exception $e) {

            throw new TapklikUploaderException($e->getMessage(), $e->getCode());
        }
    }
}
