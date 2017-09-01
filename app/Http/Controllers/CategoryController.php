<?php

namespace App\Http\Controllers;

use App\Campaign;
use App\Category;
use App\Transformers\CategoryTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

/**
 * Class CategoryController
 *
 * @package App\Http\Controllers
 */
class CategoryController extends Controller
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

            return $this->collection(Campaign::findByUuId($uuid)->categories, new CategoryTransformer);
        } catch (ModelNotFoundException $e) {
            
            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign '.$uuid.' does not exist.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param                           $uuid
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $uuid)
    {

        try {

            $campaign = Campaign::findByUuId($uuid);

            if ($request->offsetExists(0)) {

                $codes = collect($request->input())->map(
                        function ($iabCode) use ($campaign) {

                            try {
                                $category = Category::findByIabCode($iabCode);

                                return $category->id;
                            } catch (ModelNotFoundException $e) {
                                // skip
                            }
                        }
                    );

                $campaign->categories()->sync($codes);

                return $this->collection($campaign->categories, new CategoryTransformer);
            }
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign '.$uuid.' does not exist.');
        }
    }
}
