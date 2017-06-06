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
                        'message' => 'Unauthorized',
                        'request' => md5(rand(999, 9999)).'.'.sha1(Carbon::now()),
                    ],
                ]
            );
        }

        // Validate bearer
        $token = str_replace('Bearer ', '', $request->header('Authorization'));
        $payload = (new Parser())->parse((string) $token);

        if( !$payload->getClaim('accountId') || !$payload->getClaim('id')) {
            return response()->json(
                [
                    'error' => [
                        'code'    => Response::HTTP_FORBIDDEN,
                        'message' => 'Unauthorized',
                        'request' => md5(rand(999, 9999)).'.'.sha1(Carbon::now()),
                    ],
                ]
            );
        }

        $request->attributes->add([
            'token' => $payload
        ]);

        return $next($request);
    }
}
