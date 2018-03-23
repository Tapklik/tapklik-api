<?php namespace App\Http\Controllers\Core;

use App\Campaign;
use App\Http\Controllers\Controller;
use App\Transformers\TaskerCampaignTransformer;

class TaskerCampaignStartsController extends Controller
{

    public function index()
    {
	    $campaigns = Campaign::toStart()->with(['account.users'])->get();

	    return $this->collection($campaigns, new TaskerCampaignTransformer());
    }
}
