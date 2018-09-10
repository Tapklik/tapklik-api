<?php namespace Tapklik\Uploader;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tapklik\Uploader\Contracts\AbstractUploader;

class Service extends AbstractUploader
{
    public function move($account_uuid, UploadedFile $file)
    {
        return $this->driver->move($account_uuid, $file);
    }

    public function save(File $file) {

        return $this->storage->getStorage()->save($file);
    }
}
