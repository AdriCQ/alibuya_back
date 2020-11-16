<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers\Shop')->group(function () {
  /**
   * Product Routes
   */
  Route::prefix('/product')->group(function () {
    Route::post('/', 'ProductController@store')->middleware('auth:sanctum');
    Route::get('/all-paginated', 'ProductController@allPaginated');
    Route::get('/suggested', 'ProductController@suggested');
  });

  /**
   * Category Routes
   */
  Route::prefix('/category')->group(function () {
    Route::get('/', 'CategoryController@products');
  });

  /**
   * Pack Routes
   */
  Route::prefix('/pack')->middleware('auth:sanctum')->group(function () {
    Route::get('/', 'PackController@userNoBought');
    Route::post('/', 'PackController@store');
  });

  /**
   * Buy Routes
   */
  Route::prefix('/buy')->middleware('auth:sanctum')->group(function () {
    Route::get('/', 'BuyController@userBuyList');
    Route::post('/', 'BuyController@buy');
  });
});
