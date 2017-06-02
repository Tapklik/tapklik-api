<?php

namespace Tests;

use App\Http\Response\FractalResponse;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use League\Fractal\Manager;
use League\Fractal\Serializer\DataArraySerializer;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function collection($data, $transformer, $statusCode = 200, $resource = null)
    {
        $fractal = new FractalResponse(new Manager, new DataArraySerializer);

        return $fractal->collection($data, $transformer, $resource, $statusCode);
    }

    public function item($data, $transformer, $statusCode = 200, $resource = null)
    {
        $fractal = new FractalResponse(new Manager, new DataArraySerializer);

        return $fractal->item($data, $transformer, $resource, $statusCode);
    }
}
