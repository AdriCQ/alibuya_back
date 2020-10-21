<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers\Shop')->group(function () {
  /**
   * Product Routes
   */
  Route::prefix('/product')->group(function () {
    Route::get('/all-paginated', 'ProductController@allPaginated');
    Route::get('/suggested', 'ProductController@suggested');
  });
});
