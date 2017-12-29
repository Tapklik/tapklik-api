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
            $object = $this->client->upload(
                getenv('AWS_BUCKET'),
                'creatives'.$file->getFilename(),
                $file,
                'public-read'
            );

            return ['iurl' => $object->get('ObjectURL')];
        } catch (S3Exception $e) {

            throw new TapklikUploaderException($e->getMessage(), $e->getCode());
        }
    }

}
