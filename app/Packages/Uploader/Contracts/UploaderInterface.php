<?php namespace Tapklik\Uploader\Contracts;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class UploaderInterface
 *
 * @package \Tapklik\Uploader\Contracts
 */
interface UploaderInterface
{
    public function move(UploadedFile $file) : File;

    public function makeName(File $file) : String;

    public function getFile() : File;
}
