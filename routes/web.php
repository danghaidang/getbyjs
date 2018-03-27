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

Route::group(['prefix'=>'/'], function() {
    Route::get('/', ['as'=> 'getHome', 'uses'=>'HomeController@getHome']);
    Route::get('/get/{query}', ['as'=>'getList', 'uses'=>'HomeController@getList']);
});


Route::group(['prefix'=>'/getlinks'], function() {
    Route::get('/', ['as'=>'getListView', 'uses'=>'LinksController@getListView']);
    Route::get('/get', ['as'=>'getListLink', 'uses'=>'LinksController@getList']);
});
