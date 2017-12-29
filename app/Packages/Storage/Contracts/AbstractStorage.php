<?php

namespace Tapklik\Storage\Contracts;

use Tapklik\Uploader\Contracts\UploaderInterface;

/**
 * Class AbstractStorage
 *
 * @package \Tapklik\Storage\Contracts
 */
abstract class AbstractStorage
{

    protected $uploader = false;
    protected $storage  = false;

    public function __construct(UploaderInterface $uploader, StorageInterface $storage)
    {

        $this->uploader = $uploader;
        $this->storage  = $storage;
    }
}
