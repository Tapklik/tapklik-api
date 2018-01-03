<?php namespace Tapklik\Storage\Adapters;

use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use Symfony\Component\HttpFoundation\File\File;
use Tapklik\Storage\Contracts\AbstractStorageAdapter;
use Tapklik\Storage\Contracts\StorageInterface;
use Tapklik\Storage\Handlers\DefaultHandler;
use Tapklik\Uploader\Exceptions\TapklikUploaderException;

/**
 * Class S3StorageAdapter
 *
 * @package \Tapklik\Storage\Adapters
 */
class S3StorageAdapter extends AbstractStorageAdapter
{

    protected $client = false;

    public function __construct(array $config = [])
    {

        $this->client = S3Client::factory($config);
    }

    public function getStorageDriver()
    {
        return $this->client;
    }

    public function save(File $file) : Array
    {
        $type = ucfirst(strtolower($file->getExtension()));

        $handler = class_exists($class = "\\Tapklik\\Storage\\Handlers\\{$type}Handler") ? new $class : new
        DefaultHandler;

        try {
            return $handler->handle($file, $this);
        } catch (TapklikUploaderException $e) {

            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

}
