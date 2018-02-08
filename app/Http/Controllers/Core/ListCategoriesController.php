<?php

namespace App\Http\Controllers\Core;

use App\Category;
use App\Http\Controllers\Controller;
use App\Transformers\CoreCategoryTransformer;

/**
 * Class AccountController
 *
 * @package App\Http\Controllers
 */
class ListCategoriesController extends Controller
{
    public function index()
    {
    	    $categories = Category::orderBy('code')->get();

    	    return $this->collection($categories, new CoreCategoryTransformer);
    }
}
