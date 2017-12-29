<?php namespace Tapklik\Storage;

use Tapklik\Storage\Contracts\AbstractStorage;
use Tapklik\Storage\Contracts\StorageInterface;

/**
 * Class Container
 *
 * @package \Tapklik\Storage
 */
class Container extends AbstractStorage
{
    protected $storage = false;

    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;
    }

    public function getStorage()
    {
        return $this->storage;
    }
}
