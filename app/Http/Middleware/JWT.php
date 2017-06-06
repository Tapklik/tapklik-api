<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Lcobucci\JWT\Parser;

class JWT
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // Check for bearer
        if ( !$request->header('Authorization')) {

            return response()->json(
                [
                    'error' => [
                        'code'    => Response::HTTP_FORBIDDEN,
                        'message' => 'Forbidden',
                        'request' => md5(rand(999, 9999)).'.'.sha1(Carbon::now()),
                    ],
                ], Response::HTTP_FORBIDDEN
            );
        }

        // Validate bearer
        $token   = str_replace('Bearer ', '', $request->header('Authorization'));
        try {

            $payload = (new Parser())->parse((string)$token);
        } catch (\Exception $e) {

            return response()->json(
                [
                    'error' => [
                        'code'    => Response::HTTP_FORBIDDEN,
                        'message' => 'Forbidden',
                        'request' => md5(rand(999, 9999)).'.'.sha1(Carbon::now()),
                    ],
                ], Response::HTTP_UNAUTHORIZED
            );
        }


        if ( !$payload->getClaim('accountId') || !$payload->getClaim('id')) {
            return response()->json(
                [
                    'error' => [
                        'code'    => Response::HTTP_UNAUTHORIZED,
                        'message' => 'Forbidden',
                        'request' => md5(rand(999, 9999)).'.'.sha1(Carbon::now()),
                    ],
                ], Response::HTTP_FORBIDDEN
            );
        }


        $request->attributes->add(
            [
                'session' => [
                    'id'          => $payload->getClaim('id'),
                    'uuid'        => $payload->getClaim('uuid'),
                    'accountId'   => $payload->getClaim('accountId'),
                    'accountUuId' => $payload->getClaim('accountUuId'),
                    'name'        => $payload->getClaim('name'),
                    'email'       => $payload->getClaim('email'),
                ],
        ]);

        return $next($request);
    }
}
