<?php namespace Tapklik\Uploader\Contracts;

use Tapklik\Storage\Contracts\AbstractStorage;

/**
 * Class AbstractUploader
 *
 * @package \Tapklik\Uploader\Contracts
 */
abstract class AbstractUploader
{

    protected $driver  = false;
    protected $storage = false;

    public function __construct(UploaderInterface $driver, AbstractStorage $storage)
    {

        $this->driver  = $driver;
        $this->storage = $storage;
    }
}
