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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
/* To redirect to main login page */
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::group(['middleware' => ['web','auth'], 'prefix' => 'admin-panel'], function()
{
	Route::get('/home', 'HomeController@index')->name('home');

	/* Start-BrandController Routes */
    Route::resource('brands', 'BrandController',['except'=> ['show']]); 
    Route::get('brands/updateStatus/{id}', 'BrandController@updateStatus')->name('brands.updateStatus');
    /* End-BrandController Routes */  

    /* Start-CategoryController Routes */
    Route::resource('category', 'Category\CategoryController',['except'=> ['show']]); 
    Route::get('category/updateStatus/{id}', 'Category\CategoryController@updateStatus')->name('category.updateStatus');
    /* End-CategoryController Routes */ 


    /* Start-SubCategoryController Routes */
    Route::resource('category_sub', 'Category\SubCategoryController',['except'=> ['show']]); 
    Route::get('category_sub/updateStatus/{id}', 'Category\SubCategoryController@updateStatus')->name('category_sub.updateStatus');
    /* End-SubCategoryController Routes */ 

    /* Start-SubCategoryController Routes */
    Route::resource('category_child', 'Category\SubSubCategoryController',['except'=> ['show']]); 
    Route::get('category_child/updateStatus/{id}', 'Category\SubSubCategoryController@updateStatus')->name('category_child.updateStatus');
    /* End-SubCategoryController Routes */ 

    /* Start-UnitsController Routes */
    Route::resource('unit', 'UnitsController',['except'=> ['show']]); 
    Route::get('unit/updateStatus/{id}', 'UnitsController@updateStatus')->name('unit.updateStatus');
    /* End-UnitsController Routes */   

    /* Start-ProductController Routes */
    Route::resource('product', 'Product\ProductController'); 
    Route::post('product/insertProduct', 'Product\ProductController@insertProduct')->name('product.insertProduct');
    Route::post('product/updateProduct/{id}', 'Product\ProductController@updateProduct')->name('product.updateProduct');
    Route::get('product/showProductQuantity/{id}', 'Product\ProductController@showProductQuantity')->name('product.showProductQuantity');
    Route::post('product/insertProductQuantity/{id}', 'Product\ProductController@insertProductQuantity')->name('product.insertProductQuantity');
    Route::get('product/updateProductStatus/{id}', 'Product\ProductController@updateProductStatus')->name('product.updateProductStatus');
    Route::get('product/updateProductInStockStatus/{id}', 'Product\ProductController@updateProductInStockStatus')->name('product.updateProductInStockStatus');
    Route::get('product/updateProductQuantityStatus/{id}', 'Product\ProductController@updateProductQuantityStatus')->name('product.updateProductQuantityStatus');
    Route::get('product/updateProductQuantityInStockStatus/{id}', 'Product\ProductController@updateProductQuantityInStockStatus')->name('product.updateProductQuantityInStockStatus');
    Route::get('product/addProductImages/{id}', 'Product\ProductController@addProductImages')->name('product.addProductImages');
    Route::post('product/insertProductImages/{id}', 'Product\ProductController@insertProductImages')->name('product.insertProductImages');
    Route::get('product/destroyProductOtherImage/{id}', 'Product\ProductController@destroyProductOtherImage')->name('product.destroyProductOtherImage');
    /* End-ProductController Routes */   
});

