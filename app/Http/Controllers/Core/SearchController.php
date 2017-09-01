<?php namespace App\Http\Controllers\Core;

use App\Geography;
use App\Http\Controllers\Controller;
use App\Transformers\GeographyTransformer;

class SearchController extends Controller
{

    public function index()
    {

        return $this->collection(
            Geography::findByKey(request('key')),
            new GeographyTransformer
        );
    }
}
