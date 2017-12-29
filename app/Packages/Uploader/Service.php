<?php namespace Tapklik\Uploader;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tapklik\Uploader\Contracts\AbstractUploader;
use Tapklik\Uploader\Exceptions\TapklikUploaderException;

/**
 * Class Service
 *
 * @package \\${NAMESPACE}
 */
class Service extends AbstractUploader
{
    public function move(UploadedFile $file)
    {
        try {
            return $this->driver->move($file);
        } catch (TapklikUploaderException $e) {
            echo $e->getMessage(); die;
        }
    }

    public function save(File $file) {

        return $this->storage->getStorage()->save($file);
    }
}
