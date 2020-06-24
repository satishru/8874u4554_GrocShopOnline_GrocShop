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

/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
	return $request->user();
});
*/
// Note All Api expects 
Route::group(['prefix' => 'v1'], function()
{   
	Route::group(['middleware' => ['api_before', 'auth:api']], function()
  {
  	 // Route::get('getCategory1', 'Api\CategoryApiController@getCategory');
  });
 
  //Public Api's
	Route::group(['middleware' => ['api_before']], function()
  {
  	  Route::get('getCategory', 'Api\CategoryApiController@getCategory');
  	  Route::get('getProducts', 'Api\ProductApiController@getProducts');
      Route::get('getProductDetail', 'Api\ProductApiController@getProductDetail');
  });

});
