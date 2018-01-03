<?php namespace Tapklik\Storage\Contracts;

use Symfony\Component\HttpFoundation\File\File;
use Tapklik\Uploader\Contracts\UploaderInterface;

interface FileHandlerInterface
{
    public function handle(File $file, AbstractStorageAdapter $uploader) : Array;
}
