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

        return view('welcome');
    }
);

Route::group(
    ['prefix' => 'v1'],
    function () {

        // Campaigns
        Route::group(
            ['prefix' => 'campaigns'],
            function () {

                Route::get(
                    '/',
                    [
                        'as'   => 'campaigns.index',
                        'uses' => 'CampaignController@index',
                    ]
                );

                Route::get(
                    '/{id}',
                    [
                        'as'   => 'campaigns.show',
                        'uses' => 'CampaignController@show',
                    ]
                );

                Route::put(
                    '/{id}',
                    [
                        'as'   => 'campaigns.update',
                        'uses' => 'CampaignController@update',
                    ]
                );

                Route::delete(
                    '/{id}',
                    [
                        'as'   => 'campaigns.destroy',
                        'uses' => 'CampaignController@destroy',
                    ]
                );
            }
        );
    }
);
