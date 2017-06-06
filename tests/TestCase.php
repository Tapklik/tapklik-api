<?php

namespace Tests;

use App\Http\Response\FractalResponse;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use League\Fractal\Manager;
use League\Fractal\Serializer\DataArraySerializer;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJub25lIiwianRpIjoiMTIzNDUifQ.eyJpc3MiOiJodHRwOlwvXC9hcGkudGFwa2xpay5jb20iLCJhdWQiOiJodHRwOlwvXC9hcGkudGFwa2xpay5jb20iLCJqdGkiOiIxMjM0NSIsImlhdCI6MTQ5Njc0MjgwMSwiZXhwIjoxNDk5MzM0ODAxLCJlbWFpbCI6ImxzdGVockBleGFtcGxlLmNvbSIsImlkIjoxLCJ1dWlkIjoiZjk4NmEzYTYtNGE5ZC0xMWU3LTkwZTEtZjQwZjI0MjlmZmM1IiwiYWNjb3VudElkIjoyLCJuYW1lIjoiTGFyb24gTmFkZXIifQ.';

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
