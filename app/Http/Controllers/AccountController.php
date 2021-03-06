<?php

namespace App\Http\Controllers;

use App\Account;
use App\Transformers\AccountTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Log;

/**
 * Class AccountController
 *
 * @package App\Http\Controllers
 */
class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       try {
           return $this->collection(
               Account::orderBy('created_at', 'desc')->get(),
               new AccountTransformer
           );
       } catch (ModelNotFoundException $e) {

           return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Account ' . $this->req->get('session')['accountId'] . ' does not exist.');
       } catch (\Exception $e) {

           return $this->error(Response::HTTP_BAD_REQUEST, 'Unknown error', $e->getMessage());
       }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $account = Account::create($request->input());

            return $this->item($account, new AccountTransformer);
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, 'Unknown error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $uuid
     *
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        try {
            return $this->item(Account::findByUuId($uuid), new AccountTransformer());
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Account ' . $uuid . ' does not exist.');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, 'Unknown error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $uuid
     * @return \Illuminate\Http\Response
     */
    public function update($uuid)
    {
        try {
            $account = Account::findByUuId($uuid);

            $account->update($this->req->input());

            return $this->item($account, new AccountTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Account can\'t be found');
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $uuid
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        try {
            $account = Account::findByUuId($uuid);
            $account->delete();

            return ['data' => []];
        } catch (ModelNotFoundException $e) {
            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Account can\'t be found');
        }
    }
}
