<?php namespace App\Http\Controllers\Core;

use App\Campaign;
use App\Http\Controllers\Controller;
use App\Transformers\TaskerCampaignTransformer;

class TaskerCampaignExpiresController extends Controller
{

    public function index()
    {
		$campaigns = Campaign::toExpire()->with(['account.users'])->get();

		return $this->collection($campaigns, new TaskerCampaignTransformer());
    }
}
