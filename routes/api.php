<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get(
    '/user',
    function (Request $request) {

        return $request->user();
    }
);

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

        Route::post(
            '/',
            [
                'as'   => 'campaigns.store',
                'uses' => 'CampaignController@store',
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

        // Campaign Endpoints
        Route::get(
            '/{id}/adomain',
            [
                'as'   => 'campaigns.adomain.index',
                'uses' => 'AdvertiserDomainController@index',
            ]
        );

        Route::post(
            '/{id}/adomain',
            [
                'as'   => 'campaigns.adomain.store',
                'uses' => 'AdvertiserDomainController@store',
            ]
        );

        Route::get(
            '/{id}/exchange',
            [
                'as'   => 'campaigns.exchange.index',
                'uses' => 'ExchangeController@index',
            ]
        );

        Route::post(
            '/{id}/exchange',
            [
                'as'   => 'campaigns.exchange.store',
                'uses' => 'ExchangeController@store',
            ]
        );

        Route::get(
            '/{id}/cat',
            [
                'as'   => 'campaigns.categories.index',
                'uses' => 'CategoryController@index',
            ]
        );

        Route::post(
            '/{id}/cat',
            [
                'as'   => 'campaigns.categories.store',
                'uses' => 'CategoryController@store',
            ]
        );
    }
);
