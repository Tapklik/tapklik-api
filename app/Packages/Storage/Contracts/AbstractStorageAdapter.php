<?php

namespace Tapklik\Storage\Contracts;

/**
 * Class AbstractStorageAdapter
 *
 * @package \Tapklik\Storage\Contracts
 */
abstract class AbstractStorageAdapter implements StorageInterface
{
    public abstract function __construct(array $config = []);
}
