<?php

namespace App\Http\Controllers;


use App\AccountExchange;
use App\Transformers\AccountExchangeTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class ExchangeController
 *
 * @package App\Http\Controllers
 */
class AccountExchangesController extends Controller
{

    public function index()
    {
        $exchanges = AccountExchange::all();

        return $this->collection($exchanges, new AccountExchangeTransformer());
    }

    public function show($identifier)
    {
        try {
            $exchange = AccountExchange::where(['identifier' => $identifier])->firstOrFail();

            return $this->item($exchange, new AccountExchangeTransformer());
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Exchange not found');
        }
    }
}
