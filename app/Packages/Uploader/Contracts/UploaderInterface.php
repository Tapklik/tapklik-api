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
    public function move($account_uuid, UploadedFile $file) : File;

    public function makeName($account_uuid, File $file) : String;

    public function getFile() : File;
}
