<?php namespace Tapklik\Uploader;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tapklik\Uploader\Contracts\AbstractUploader;

class Service extends AbstractUploader
{
    public function move(UploadedFile $file)
    {
        return $this->driver->move($file);
    }

    public function save(File $file) {

        return $this->storage->getStorage()->save($file);
    }
}
