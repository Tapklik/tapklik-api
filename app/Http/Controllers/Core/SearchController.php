<?php namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function search()
    {
        var_dump(request('key'));
    }
}
