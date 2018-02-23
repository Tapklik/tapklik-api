<?php

namespace App\Http\Controllers\Core;

use App\Category;
use App\Events\Status;
use App\Http\Controllers\Controller;

/**
 * Class AccountController
 *
 * @package App\Http\Controllers
 */
class CampaignsController extends Controller
{
    public function index()
    {
		event(new Status());
    }
}
