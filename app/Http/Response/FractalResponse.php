<?php namespace App\Http\Response;

use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Serializer\SerializerAbstract;
use League\Fractal\TransformerAbstract;

class FractalResponse
{

    /**
     * @var Manager
     */
    private $_manager;

    /**
     * @var SerializerAbstract
     */
    private $_serializer;

    /**
     * FractalResponse constructor.
     *
     * @param Manager            $manager
     * @param SerializerAbstract $serializer
     */
    public function __construct(Manager $manager, SerializerAbstract $serializer)
    {

        $this->_manager    = $manager;
        $this->_serializer = $serializer;

        $this->_manager->setSerializer($this->_serializer);
    }

    /**
     * @param                     $data
     * @param TransformerAbstract $transformer
     * @param null                $resourceKey
     *
     * @return array
     */
    public function item($data, TransformerAbstract $transformer, $resourceKey = null, $statusCode = 200)
    {

        $resource = new Item($data, $transformer, $resourceKey);

        return $this->_manager->createData($resource)->toArray();
    }

    /**
     * @param                     $data
     * @param TransformerAbstract $transformer
     * @param null                $resourceKey
     *
     * @return array
     */
    public function collection($data, TransformerAbstract $transformer, $resourceKey = null, $statusCode = 200)
    {

        $resource = new Collection($data, $transformer, $resourceKey);

        return $this->_manager->createData($resource)->toArray();
    }
}
