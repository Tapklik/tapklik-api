<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Demography;
use App\Transformers\DemographyTransformer;
use App\Transformers\UserTransformer;
use App\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class DemographyController
 *
 * @package App\Http\Controllers
 */
class DemographyController extends Controller
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

            return $this->item($campaign->demography ?: factory(Demography::class)->create([
                'campaign_id' => $campaign->id
            ]), new
            DemographyTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign ' . $uuid . ' does not exist.');
        }
    }

    public function store($uuid)
    {

        try {
            $campaign = Campaign::findByUuId($uuid);

            try {
                $user = $campaign->demography()->firstOrFail();
                $user->delete();
            } catch (ModelNotFoundException $e) {}

            try {
                $gender = request('gender');
                $age    = request('age');

                $demography = Demography::saveDemography(
                    $gender,
                    $age['min'],
                    $age['max'],
                    $campaign->id
                );

                return $this->item($demography, new DemographyTransformer);
            } catch (Exception $e) {

                return $this->error(Response::HTTP_BAD_REQUEST, $e->getMessage());
            }



        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, $e->getMessage());
        }
    }

    public function update($accountId, $userId)
    {
        try {
            $user = User::findByUuId($userId);

            $data = $this->req->input();
            if(isset($data['password'])) $data['password'] = bcrypt(request('password'));
            $user->update($data);

            return $this->item($user, new UserTransformer);
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Demography  $demography
     * @return \Illuminate\Http\Response
     */
    public function destroy(Demography $demography)
    {
        //
    }
}
