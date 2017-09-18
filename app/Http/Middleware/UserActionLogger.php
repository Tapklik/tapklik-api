<?php namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Lcobucci\JWT\Parser;
use GuzzleHttp\Exception\GuzzleException;

class UserActionLogger
{

    private $_user = [];

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

        $payload = $this->_validateToken($request->header('Authorization'));

        if(!$payload) return $next($request);

        $this->_user = collect(
            ['id'          => $payload->getClaim('id'),
             'uuid'        => $payload->getClaim('uuid'),
             'accountId'   => $payload->getClaim('accountId'),
             'accountUuId' => $payload->getClaim('accountUuId'),
             'name'        => $payload->getClaim('name'),
             'email'       => $payload->getClaim('email'),
             'campaigns'   => $payload->getClaim('campaigns')]
        );

        $section   = $this->_retrieveSection($request->getRequestUri());
        $verbalize = $this->_retrieveAction($request->getMethod());
        $sentence  = $this->_user->get('name') . ' ' . $verbalize . ' ' . $section->get(0);

        if($section->offsetExists(1)) $sentence .= ' #' . $section->get(1);

        $this->_sendToLoggly($sentence);

        return $next($request);
    }

    private function _sendToLoggly($sentece)
    {
        $client = new Client([
            'base_uri' => 'http://logs-01.loggly.com'
        ]);

        try {
            $client->post('inputs/67a90950-78f3-4a24-86be-0a57c3461280/tag/account-' . $this->_user->get('id'), [
                'json' => [
                    'message' => $sentece
                ]
            ]);
        } catch (GuzzleException $e) {
            // drop it here
            dd('UserActionLogger Middleware:' . $e->getMessage());
        }

    }

    private function _validateToken(string $token = '')
    {

        if(!$token) return null;

        // Validate bearer
        $token = str_replace('Bearer ', '', $token);

        try {

            $payload = (new Parser())->parse((string)$token);

            return $payload;
        } catch (\Exception $e) {

            return response()->json(
                ['error' => ['code'    => Response::HTTP_FORBIDDEN,
                             'message' => 'Forbidden',
                             'request' => md5(rand(999, 9999)).'.'.sha1(Carbon::now()),],],
                Response::HTTP_UNAUTHORIZED
            );
        }
    }

    private function _retrieveSection(string $basePath)
    {

        // Remove redundancy
        $ommitBag      = ['v1', '?'];
        $segmentedPath = explode('/', $basePath);

        $path = collect($segmentedPath)->filter(
            function ($segment) use ($ommitBag) {

                if ( !in_array($segment, $ommitBag)) {
                    return $segment;
                }
            }
        )->flatten();

        return collect($path);
    }

    private function _retrieveAction(string $method)
    {

        $verbBag = ['GET'    => 'requested',
                    'POST'   => 'created',
                    'PUT'    => 'updated',
                    'DELETE' => 'deleted'];

        return $verbBag[$method];
    }
}
