<?php namespace Tapklik\Uploader\Drivers;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Tapklik\Uploader\Contracts\UploaderInterface;
use Tapklik\Uploader\Exceptions\TapklikUploaderException;

/**
 * Class ZipDriver
 *
 * @package \Tapklik\Uploader\Drivers
 */
class DefaultDriver implements UploaderInterface
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
}
