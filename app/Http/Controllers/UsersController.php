<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class UsersController extends Controller
{

    /**
     * Remove the specified resource from storage.
     *
     * @param $accountUuId
     * @param $userUuId
     *
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy($accountUuId, $userUuId)
    {
        try {
            $user = User::findByUuId($userUuId);
            $user->delete();

            return ['data' => []];
        } catch (ModelNotFoundException $e) {
            return $this->error(Response::HTTP_NOT_FOUND, $e->getMessage());
        }
    }
}
