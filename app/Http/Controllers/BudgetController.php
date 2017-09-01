<?php

namespace App\Http\Controllers;

use App\Budget;
use App\Campaign;
use App\Transformers\BudgetTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * Class BudgetController
 *
 * @package App\Http\Controllers
 */
class BudgetController extends Controller
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
            $campaign = Campaign::findByUuId($uuid);

            return $this->item(
                $campaign->budget
                    ?: factory(Budget::class)->create(
                    [
                        'campaign_id' => $campaign->id,
                    ]
                ),
                new BudgetTransformer
            );
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign '.$uuid.' does not exist.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $uuid)
    {
        try {
            $campaign = Campaign::findByUuId($uuid);

            Budget::deleteForCampaignId($campaign->id);

            $budget = Budget::create([
                'type' => request('type') ?: 'daily',
                'amount' => request('amount'),
                'pacing' => request('pacing'),
                'campaign_id' => $campaign->id
            ]);

            return $this->item($budget, new BudgetTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign '.$uuid.' does not exist.');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Unknown error', $e->getMessage() . ' = ' . $e->getFile()
            . ' | ' . $e->getLine());
        }
    }
}
