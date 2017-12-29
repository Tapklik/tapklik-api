<?php namespace Tapklik\Uploader\Drivers;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tapklik\Uploader\Contracts\CanUnzipFiles;
use Tapklik\Uploader\Contracts\UploaderInterface;
use Tapklik\Uploader\Exceptions\TapklikUploaderException;

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

    public function move(UploadedFile $file) : File
    {

        try {
            $this->_file = $file->move($this->_location, $this->makeName($file));

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

    public function makeName(File $file) : String
    {

        return sha1($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
    }

    public function unzip(string $file, string $location)
    {
        $tempFolder = str_replace('.zip', '', $this->getFile()->getBasename());

        $zip = new \ZipArchive();
        $zip->open($file);
        $zip->extractTo($location . '/' . $tempFolder);
        $zip->close();

        return $tempFolder;
    }
}
