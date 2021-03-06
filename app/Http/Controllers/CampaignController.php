<?php namespace App\Http\Controllers;

use App\Account;
use App\Campaign;
use App\Transformers\CampaignTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\User;
use Notification;
use App\Notifications\CreateCampaign;
use App\Notifications\PauseCampaign;
use App\Notifications\ExpireCampaign;

/**
 * Class CampaignController
 *
 * @package App\Http\Controllers
 */
class CampaignController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        try {
            if($this->getJwtUserClaim('role') == 1) return $this->collection(Campaign::all(), new CampaignTransformer());

            $campaigns = Campaign::findByAccountId(
                $this->req->get('session')['accountId']
            );

            Log::info("Listed campaigns {account}", [
                'account' => $this->req->get('session')['accountId']
            ]);

            return $this->collection($campaigns, new CampaignTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {

            $payload = [
                'account_id'  => $this->getJwtUserClaim('accountId') ?: 1,
                'name'        => request('name'),
                'description' => request('description'),
                'start'       => request('start'),
                'end'         => request('end'),
                'bid'         => request('bid'),
                'ctrurl'      => request('ctrurl'),
                'adomain'     => request('adomain'),
                'test'        => request('test'),
                'weight'      => request('weight'),
                'node'        => request('node'),
                'status'      => request('status'),
            ];

            $campaign = Campaign::create($payload);

            $actionToLog = sprintf('%s created a new campaign named %s with ID#%s',
                $this->getJwtUserClaim('name'),
                $campaign->name,
                $campaign->uuid
            );

            $this->logActionToLoggerProvider($actionToLog);

            return $this->item($campaign, new CampaignTransformer);
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, $e->getMessage());
        }
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @param                          $uuid
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $uuid)
    {

        try {
            $campaign = Campaign::findByUuId($uuid);

            return $this->item($campaign, new CampaignTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign '.$uuid.' does not exist.');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, 'Unknown error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param                           $uuid
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $uuid)
    {

        try {
            $campaign = Campaign::findByUuId($uuid);
            $campaign_old_status = $campaign->status;
            $campaign->update($request->input());
            $campaign_new_status = $campaign->status;
            $account_id = $campaign->account_id;
            $users = User::findByAccountId($account_id);

            $actionToLog = sprintf('%s created a new campaign #%s named %s',
                $this->getJwtUserClaim('name'),
                $campaign->uuid,
                $campaign->name
            );
            if($campaign_old_status != $campaign_new_status) {
                if($campaign_new_status == 'active') {
                    Notification::send($users, new CreateCampaign($campaign->uuid));
                }
                if($campaign_new_status == 'paused') {
                    Notification::send($users, new PauseCampaign($campaign->uuid));
                }
                if($campaign_new_status == 'expired') {
                    Notification::send($users, new ExpireCampaign($campaign->uuid));
                }
            }

            $this->logActionToLoggerProvider($actionToLog);

            return $this->item($campaign, new CampaignTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, 'Unknown', $e->getMessage());
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
            Campaign::findByUuId($uuid)->delete();

            $actionToLog = sprintf('%s deleted campaign ID#%s',
                $this->getJwtUserClaim('name'),
                $uuid
            );

            // Don't log draft requests
            if(request('status') !== 'draft') $this->logActionToLoggerProvider($actionToLog);

            return response()->json(['data' => '']);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, 'Unknown', $e->getMessage());
        }
    }
}
