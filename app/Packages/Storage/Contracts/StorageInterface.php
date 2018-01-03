<?php namespace Tapklik\Storage\Contracts;

use Symfony\Component\HttpFoundation\File\File;

/**
 * Class StorageInterface
 *
 * @package \Tapklik\Storage\Contracts
 */
interface StorageInterface
{
    public function save(File $file) : Array;

    public function getStorageDriver();
}
