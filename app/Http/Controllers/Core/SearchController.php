<?php namespace App\Http\Controllers\Core;

use App\Geography;
use App\Http\Controllers\Controller;
use App\Transformers\SearchTransformer;

class SearchController extends Controller
{
    public function search()
    {
        $results = Geography::findByKey(request('key'));

        return $this->collection($results, new SearchTransformer);
    }
}
