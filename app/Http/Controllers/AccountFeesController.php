<?php namespace App\Http\Controllers;

use App\Account;
use App\Transformers\AccountTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

/**
 * Class AccountController
 *
 * @package App\Http\Controllers
 */
class AccountFeesController extends Controller
{

    public function update(string $uuid)
    {

        try {
            $account = Account::findByUuId($uuid);
            $account->update($this->req->input());

            return $this->item($account, new AccountTransformer());
        } catch (ModelNotFoundException $e) {
            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Account '.$uuid.' does not exist.');
        }
    }
}
