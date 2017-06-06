<?php

namespace Tests;

use App\Http\Response\FractalResponse;
use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\App;
use League\Fractal\Manager;
use League\Fractal\Serializer\DataArraySerializer;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $token = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJub25lIiwianRpIjoiMTIzNDUifQ.eyJpc3MiOiJodHRwOlwvXC9hcGkudGFwa2xpay5jb20iLCJhdWQiOiJodHRwOlwvXC9hcGkudGFwa2xpay5jb20iLCJqdGkiOiIxMjM0NSIsImlhdCI6MTQ5Njc0NDk5MywiZXhwIjoxNDk5MzM2OTkzLCJlbWFpbCI6ImhhbGlkQHRhcGtsaWsuY29tIiwiaWQiOjYsInV1aWQiOiI4ZDg4Y2NhMi00YWExLTExZTctYWNjOS1mNDBmMjQyOWZmYzUiLCJhY2NvdW50SWQiOjEsImFjY291bnRVdUlkIjoiMTFjZTY3ZjgtNGE5Yi0xMWU3LTk1YmUtZjQwZjI0MjlmZmM1IiwibmFtZSI6IkhhbGlkIE1vdXNhIn0.';

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

    public function generateApiToken($accountId = 1)
    {
        $user = factory(User::class)->make(['account_id' => $accountId]);

        return User::apiToken($user);
    }
}
