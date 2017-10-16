<?php namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

/**
 * Class AuthenticateController
 *
 * @package App\Http\Controllers
 */
class AuthenticateController extends Controller
{

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate()
    {

        if ( !Auth::attempt(
            ['email'    => request('email'),
             'password' => request('password')]
        )) {
            return $this->error(Response::HTTP_UNAUTHORIZED, 'Unauthorized', 'Wrong username / password');
        }

        if (Auth::user()->status != 1)
            return $this->error(Response::HTTP_UNAUTHORIZED, 'Unauthorized', 'Your account is inactive. Please contact us at support@tapklik.com');

        return response()->json(
            ['token' => base64_encode(User::apiToken(Auth::user()))]
        );
    }
}
