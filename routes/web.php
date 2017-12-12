<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get(
    '/',
    function () {

        return response()->json(
            [
                'error' => [
                    'code'    => \Illuminate\Http\Response::HTTP_EXPECTATION_FAILED,
                    'message' => 'Nothing here',
                    'details' => 'Expectation failed',
                    'request' => ''
                ]
            ]
        );
    }
);
