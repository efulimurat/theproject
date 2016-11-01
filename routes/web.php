<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | This file is where you may define all of the routes that are handled
  | by your application. Just tell Laravel the URIs it should respond
  | to using a Closure or controller method. Build something great!
  |
 */

Route::get('/', function () {
    return redirect()->route('transactions.list');
});

/*
 * Administrator Control Groups
 */
Route::group(['prefix' => 'administrator', 'middleware' => 'auth'], function () {
    Route::get('/', 'Transactions@dashboard')->name("administrator.dashboard");
    //Transactions
    Route::group(['prefix' => 'transactions', 'namespace' => 'Admin'], function () {
        Route::get('/', function() {
            return redirect()->route('transactions.list');
        });
        Route::get('list/{page?}/{view?}', 'Transactions@all')->name("transactions.list");
        Route::get('loadInfinity/{page?}', 'Transactions@infinityLoad')->name("transactions.infinity");
        Route::get('detail/{id}', 'Transactions@detail')->name("transactions.detail");
    });

    //Merchant
    Route::group(['prefix' => 'merchant', 'namespace' => 'Admin'], function () {
        Route::get('detail/{id?}', 'Merchants@detail')->name("merchants.detail");
    });

    //Reports
    Route::group(['prefix' => 'reports', 'namespace' => 'Admin'], function () {
        Route::get('main', 'Reports@main')->name("reports.main");
//        Route::get('list/{fromDate}/{toDate}', 'Reports@all')->name("reports.list")->where(['fromDate' => '[0-9]{4}-[0-9]{2}-[0-9]{2}', 'toDate' => '[0-9]{4}-[0-9]{2}-[0-9]{2}']);;
        Route::any('list', 'Reports@all')->name("reports.list")->where(['fromDate' => '[0-9]{4}-[0-9]{2}-[0-9]{2}', 'toDate' => '[0-9]{4}-[0-9]{2}-[0-9]{2}']);
        ;
    });
});

Auth::routes();
