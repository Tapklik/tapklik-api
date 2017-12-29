<?php namespace Tapklik\Storage\Adapters;

use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use Symfony\Component\HttpFoundation\File\File;
use Tapklik\Storage\Contracts\AbstractStorageAdapter;
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

    public function save(File $file) : Array
    {
        try {
            $object = $this->client->uploadDirectory(
                public_path(str_replace('.zip', '', $file->getPathname())),
                getenv('AWS_BUCKET'),
                'creatives/html5/' . $file->getFilename()
            );
            return ['iurl' => 'https://s3-us-west-2.amazonaws.com/comtapklik/creatives/html5/' . $file->getFilename()
                . '/index.html'];
        } catch (S3Exception $e) {

            throw new TapklikUploaderException($e->getMessage(), $e->getCode());
        }
    }

}
