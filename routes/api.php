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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['namespace' => 'API'], function () {
    Route::get('/all_category', 'CategoryController@getAllCategory');
    Route::post('/category_namelist', 'CategoryController@getCategoryNameList');
    Route::get('/jobs', 'JobController@index');
    // Route::get('/job_search', 'JobController@searchJobItem');
});

