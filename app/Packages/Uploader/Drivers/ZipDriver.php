<?php namespace Tapklik\Uploader\Drivers;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tapklik\Uploader\Contracts\CanUnzipFiles;
use Tapklik\Uploader\Contracts\UploaderInterface;
use Tapklik\Uploader\Exceptions\TapklikUploaderException;
use Carbon\Carbon;
use ZipArchive;

/**
 * Class ZipDriver
 *
 * @package \Tapklik\Uploader\Drivers
 */
class ZipDriver implements UploaderInterface, CanUnzipFiles
{

    private $_file     = false;
    private $_location = '';

    public function __construct(string $location = '')
    {
        $this->_location = $location;
    }

    public function move($account_uuid, UploadedFile $file) : File
    {

        try {
            $this->_file = $file->move($this->_location, $this->makeName($account_uuid, $file));

            $this->unzip($this->_file->getPathname(), env('UPLOAD_DIR'));

            return $this->getFile();
        } catch (FileException $e) {
            throw new TapklikUploaderException('Could not move the file');
        }

        return $this;
    }

    public function getFile() : File
    {

        return $this->_file;
    }

    public function makeName($account_uuid, File $file) : String
    {
        $now = Carbon::now();
        $date = str_replace('-','',$now->toDateString());
        $id = rand(1000, 9999);
        $name = 't_' . $account_uuid . '_' . $date . '_' . $id . '.' . $file->getClientOriginalExtension();
        return $name;
    }

    public function unzip(string $file, string $location)
    {
        $tempFolder = str_replace('.zip', '', $this->getFile()->getBasename());
        $zip = new ZipArchive();
        $zip->open($file);
        $zip->extractTo($location . '/' . $tempFolder);
        $zip->close();

        return $tempFolder;
    }
}
