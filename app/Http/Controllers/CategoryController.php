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

                collect($request->input())->each(
                        function ($iabCode) use ($campaign) {

                            try {
                                $category = Category::findByIabCode($iabCode);
                                $campaign->categories()->save($category);
                            } catch (ModelNotFoundException $e) {
                                // skip
                            }
                        }
                    );

                return $this->collection($campaign->categories, new CategoryTransformer);
            }
        } catch (ModelNotFoundException $e) {

            return $this->error(Response::HTTP_NOT_FOUND, 'Not found', 'Campaign '.$uuid.' does not exist.');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category $category
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category $category
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Category            $category
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category $category
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
    }
}
