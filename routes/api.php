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

        Route::get(
            '/{id}/budget',
            [
                'as'   => 'campaigns.budget.index',
                'uses' => 'BudgetController@index',
            ]
        );

        Route::post(
            '/{id}/budget',
            [
                'as'   => 'campaigns.budget.store',
                'uses' => 'BudgetController@store',
            ]
        );

        Route::get(
            '/{id}/user',
            [
                'as'   => 'campaigns.user.index',
                'uses' => 'DemographyController@index',
            ]
        );

        // GEO HERE
        Route::get(
            '/{id}/geo',
            [
                'as'   => 'campaigns.geo.index',
                'uses' => 'GeographyController@index',
            ]
        );

        Route::get(
            '/{id}/creatives',
            [
                'as'   => 'campaigns.creatives.index',
                'uses' => 'CampaignCreativeController@index',
            ]
        );
    }
);

// Accounts
Route::group(
    ['prefix' => 'accounts'],
    function () {

        Route::get(
            '/',
            [
                'as'   => 'accounts.index',
                'uses' => 'AccountController@index',
            ]
        );

        Route::post(
            '/',
            [
                'as'   => 'accounts.store',
                'uses' => 'AccountController@store',
            ]
        );

        Route::get(
            '/{id}',
            [
                'as'   => 'accounts.show',
                'uses' => 'AccountController@show',
            ]
        );

        Route::get(
            '/{id}/users',
            [
                'as'   => 'accounts.users.index',
                'uses' => 'UserController@index',
            ]
        );

        Route::post(
            '/{id}/users',
            [
                'as'   => 'accounts.users.store',
                'uses' => 'UserController@store',
            ]
        );



        Route::get(
            '/{id}/users/{userId}',
            [
                'as'   => 'accounts.users.show',
                'uses' => 'UserController@show',
            ]
        );
    }
);

/**
 * Core namespace provides utility endpoints, such as fuzzy search
 */
Route::group(
    [
        'prefix' => 'core',
    ],
    function () {

        // Search
        // Email sending
    }
);
