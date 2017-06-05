<?php

namespace App\Http\Controllers;

use App\Account;
use App\Transformers\UserTransformer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param $uuid
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($uuid)
    {

        try {
            $account = Account::findByUuId($uuid);

            return $this->collection($account->users, new UserTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Account '.$uuid.' does not exist.');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, 'Unknown error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param                           $uuid
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $uuid)
    {

        try {
            $account = Account::findByUuId($uuid);

            $user = User::create(
                [
                    'first_name' => request('first_name'),
                    'last_name'  => request('last_name'),
                    'email'      => request('email'),
                    'password'   => request('password'),
                    'account_id' => $account->id,
                ]
            );

            return $this->item($user, new UserTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Account '.$uuid.' does not exist.');
        } catch (\Exception $e) {
            echo $e->getMessage();

            return $this->error(Response::HTTP_BAD_REQUEST, 'Unknown error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
