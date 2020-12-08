<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers\Shop')->group(function () {
  /**
   * Product Routes
   */
  Route::prefix('/product')->group(function () {
    Route::get('/by-id', 'ProductController@getById');
    Route::get('/all-paginated', 'ProductController@allPaginated');
    Route::get('/suggested', 'ProductController@suggested');
    Route::get('/search', 'ProductController@search');
  });

  /**
   * Category & Types Routes
   */
  Route::prefix('/category')->group(function () {
    Route::get('/', 'CategoryController@categories');
    Route::get('/products', 'CategoryController@products');
    Route::get('/suggested-products', 'CategoryController@suggestedProducts');
    Route::get('/type/products', 'CategoryController@productsByTypeTag');
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

  /**
   * Announcements Routes
   */
  Route::prefix('/ann')->group(function () {
    Route::get('/', 'AnnouncementController@announcements');
    Route::get('/by-id', 'AnnouncementController@getById');
  });
});
