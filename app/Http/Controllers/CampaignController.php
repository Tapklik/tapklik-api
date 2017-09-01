<?php namespace App\Http\Controllers;

use App\Campaign;
use App\Transformers\CampaignTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

            $campaigns = Campaign::findByAccountId(
                $this->req->get('session')['accountId']
            );

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
            $campaign->update($request->input());

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

            return response()->json(['data' => '']);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found');
        } catch (\Exception $e) {

            return $this->error(Response::HTTP_BAD_REQUEST, 'Unknown', $e->getMessage());
        }
    }
}
