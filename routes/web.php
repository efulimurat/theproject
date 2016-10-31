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
    return view('welcome');
});

/*
 * Administrator Control Groups
 */
Route::group(['prefix' => 'administrator', 'middleware' => 'auth'], function () {
    //Transactions
    Route::group(['prefix' => 'transactions', 'namespace' => 'Admin'], function () {
        Route::get('list/{page?}/{view?}', 'Transactions@all')->name("transactions.list");
        Route::get('loadInfinity/{page?}', 'Transactions@infinityLoad')->name("transactions.infinity");
    });
});

/*
  Route::group(['prefix' => 'administrator/transactions','middleware' =>'auth'], function () {

  Route::get('transactions/list/{page}','Transactions@listme')->where('slug', '[0-9A-Za-z/]+');
  //    Route::get('{controller?}/{method?}/{params?}', function($controller, $method = "index", $params = ""){
  //
  //            return $controller."/".$method;
  //    });
  Route::get('ajax/{method?}', 'Administration@index');
  });
 */
Auth::routes();
