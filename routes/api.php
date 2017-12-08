<?php

use App\Http\Middleware\JWT;

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

// Campaigns
Route::group(
    ['prefix' => 'campaigns', 'middleware' => JWT::class],
    function () {
        Route::get(
            '/',
            ['as'   => 'campaigns.index',
             'uses' => 'CampaignController@index',]
        );

        Route::post(
            '/',
            ['as'   => 'campaigns.store',
             'uses' => 'CampaignController@store',]
        );

        Route::get(
            '/{id}',
            ['as'   => 'campaigns.show',
             'uses' => 'CampaignController@show',]
        );

        Route::put(
            '/{id}',
            ['as'   => 'campaigns.update',
             'uses' => 'CampaignController@update',]
        );

        Route::delete(
            '/{id}',
            ['as'   => 'campaigns.destroy',
             'uses' => 'CampaignController@destroy',]
        );

        // ADVERTISER DOMAIN
        Route::get(
            '/{id}/adomain',
            ['as'   => 'campaigns.adomain.index',
             'uses' => 'AdvertiserDomainController@index',]
        );

        Route::post(
            '/{id}/adomain',
            ['as'   => 'campaigns.adomain.store',
             'uses' => 'AdvertiserDomainController@store',]
        );

        // EXCHANGE
        Route::get(
            '/{id}/exchange',
            ['as'   => 'campaigns.exchange.index',
             'uses' => 'ExchangeController@index',]
        );

        Route::post(
            '/{id}/exchange',
            ['as'   => 'campaigns.exchange.store',
             'uses' => 'ExchangeController@store',]
        );

        Route::get(
            '/{id}/banker/{table}',
            ['as'   => 'campaigns.banker.index',
             'uses' => 'BankerController@index']
        );

        Route::post(
            '/{id}/banker/{table}',
            ['as'   => 'campaigns.banker.store',
             'uses' => 'BankerController@store']
        );

        // CATEGORIES
        Route::get(
            '/{id}/cat',
            ['as'   => 'campaigns.categories.index',
             'uses' => 'CategoryController@index',]
        );

        Route::post(
            '/{id}/cat',
            ['as'   => 'campaigns.categories.store',
             'uses' => 'CategoryController@store',]
        );

        // BUDGET
        Route::get(
            '/{id}/budget',
            ['as'   => 'campaigns.budget.index',
             'uses' => 'BudgetController@index',]
        );

        Route::post(
            '/{id}/budget',
            ['as'   => 'campaigns.budget.store',
             'uses' => 'BudgetController@store',]
        );

        // USER
        Route::get(
            '/{id}/users',
            ['as'   => 'campaigns.user.index',
             'uses' => 'DemographyController@index',]
        );

        Route::post(
            '/{id}/users',
            ['as'   => 'campaigns.user.store',
             'uses' => 'DemographyController@store',]
        );

        // GEO
        Route::get(
            '/{id}/geo',
            ['as'   => 'campaigns.geo.index',
             'uses' => 'GeographyController@index',]
        );

        Route::post(
            '/{id}/geo',
            ['as'   => 'campaigns.geo.store',
             'uses' => 'GeographyController@store',]
        );

        // CREATIVES
        Route::get(
            '/{id}/creatives',
            ['as'   => 'campaigns.creatives.index',
             'uses' => 'CampaignCreativeController@index',]
        );

        Route::post(
            '/{id}/creatives',
            ['as'   => 'campaigns.creatives.store',
             'uses' => 'CampaignCreativeController@store',]
        );

        // DEVICE
        Route::get(
            '/{id}/device',
            ['as'   => 'campaigns.devices.index',
             'uses' => 'CampaignDeviceController@index']
        );

        Route::post(
            '/{id}/device/type',
            ['as'   => 'campaigns.type.store',
             'uses' => 'CampaignsTypeController@store']
        );

        Route::post(
            '/{id}/device/model',
            ['as'   => 'campaigns.model.store',
             'uses' => 'CampaignsModelController@store']
        );

        Route::post(
            '/{id}/device/os',
            ['as'   => 'campaigns.os.store',
             'uses' => 'CampaignsOsController@store']
        );
    }
);

// Accounts
Route::group(
    ['prefix' => 'accounts', 'middleware' => JWT::class],
    function () {

        Route::get(
            '/',
            ['as'   => 'accounts.index',
             'uses' => 'AccountController@index',]
        );

        Route::get(
            '/info',
            ['as'   => 'accounts.info',
             'uses' => 'UserController@info']
        );

        Route::post(
            '/',
            ['as'   => 'accounts.store',
             'uses' => 'AccountController@store',]
        );

        /** LOGS */
        Route::get('/log', [
            'as' => 'accounts.log.index',
            'uses' => 'AccountsLogController@index'
        ]);

        Route::get(
            '/{id}',
            ['as'   => 'accounts.show',
             'uses' => 'AccountController@show',]
        );

        Route::put(
            '/{id}',
            ['as'   => 'accounts.update',
             'uses' => 'AccountController@update',]
        );

        Route::delete(
            '/{id}',
            ['as'   => 'accounts.destroy',
             'uses' => 'AccountController@destroy']
        );

        Route::get('/{id}/campaigns ', [
            'as' => 'accounts.campaigns.index',
            'uses' => 'AccountsCampaignController@index'
        ]);

        Route::get(
            '/{id}/users',
            ['as'   => 'accounts.users.index',
             'uses' => 'UserController@index',]
        );

        Route::post(
            '/{id}/users',
            ['as'   => 'accounts.users.store',
             'uses' => 'UserController@store',]
        );

        Route::get(
            '/{id}/users/{userId}',
            ['as'   => 'accounts.users.show',
             'uses' => 'UserController@show',]
        );

        Route::put(
            '/{id}/users/{userId}',
            ['as'   => 'campaigns.user.update',
             'uses' => 'DemographyController@update',]
        );

        Route::delete(
            '/{id}/users/{userId}',
            ['as'   => 'user.destroy',
             'uses' => 'UsersController@destroy',]
        );

        Route::get(
            '/{id}/banker/{table}',
            ['as'   => 'account.banker.index',
             'uses' => 'BankerController@index']
        );

        Route::post(
            '/{id}/banker/{table}',
            ['as'   => 'account.banker.store',
             'uses' => 'BankerController@store']
        );

        Route::delete(
            '/{id}/banker/{table}',
            ['as'   => 'account.banker.destroy',
             'uses' => 'BankerController@destroy']
        );
    }
);

// Creatives
Route::group(
    ['prefix' => 'creatives', 'middleware' => JWT::class],
    function () {

        Route::post(
            '/',
            ['as'   => 'creatives.upload',
             'uses' => 'UploadController@store']
        );

        Route::get('/{id}/folders', [
            'as' => 'creatives.folder.admin.index',
            'uses' => 'AdminFolderController@index'
        ]);

        Route::get('/{id}/folders/{folderId}', [
            'as' => 'creatives.folder.admin.show',
            'uses' => 'AdminFolderController@show'
        ]);

        Route::get(
            '/folders',
            ['as'   => 'creatives.folders.index',
             'uses' => 'FolderController@index']
        );

        Route::delete(
            '/folders/{id}',
            ['as'   => 'creatives.folders.delete',
             'uses' => 'FolderController@delete']
        );

        Route::put('/{id}', [
            'as' => 'creatives.update',
            'uses' => 'CreativesController@update'
        ]);

        Route::get(
            '/{id}',
            ['as'   => 'creatives.show',
             'uses' => 'CreativesController@show']
        );

        Route::delete('/{id}', [
            'as' => 'creatives.delete',
            'uses' => 'CreativesController@delete'
        ]);

        Route::post(
            '/folders',
            ['as'   => 'creatives.folders.store',
             'uses' => 'FolderController@store',]
        );

        Route::get(
            '/folders/{id}',
            ['as'   => 'creatives.folders.show',
             'uses' => 'FolderController@show',]
        );
    }
);

/**
 * Core namespace provides utility endpoints, such as fuzzy search
 */
Route::group(
    ['prefix' => 'core', 'namespace' => 'Core'],
    function () {

        Route::group(
            ['prefix' => 'search'],
            function () {

                Route::get(
                    '/geo',
                    ['as'   => 'core.search.geo',
                     'uses' => 'SearchController@index']
                );
            }
        );

        Route::group(
            ['prefix' => '/erlang',],
            function () {


                Route::get(
                    '/campaigns',
                    ['as'   => 'core.erlang.campaigns',
                     'uses' => 'ErlangCampaignsController@index']
                );
            }
        );

        Route::group(['prefix' => 'mail'], function () {

            // Email sending
            Route::post('send', [
                'as' => 'core.mail.index',
                'uses' => 'MailController@index'
            ]);
        });


        Route::group(['prefix' => 'list'], function () {

            // Categories

            // Types

            // Os

            // Models
        });

    }
);

/**
 * Core namespace provides utility endpoints, such as fuzzy search
 */
Route::post(
    '/auth',
    ['as'   => 'auth',
     'uses' => 'AuthenticateController@authenticate']
);

Route::get('/health', [
    'as' => 'health',
    'uses' => 'HealthCheckController@index'
]);
