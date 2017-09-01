<?php

namespace App\Http\Controllers;

use App\Account;
use App\Transformers\CampaignTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class AccountsCampaignController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param $uuid
     *
     * @return \Illuminate\Http\Response
     */
    public function index($uuid)
    {
        try {
            $account = Account::findByUuId($uuid);

            return $this->collection($account->campaigns, new CampaignTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Account can\'t be found');
        }
    }
}
