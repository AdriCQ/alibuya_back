<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers\Shop')->middleware('auth:sanctum')->group(function () {
  Route::post('/', 'VendorController@store');
  Route::post('/product', 'ProductController@store');
  Route::get('/by-auth', 'VendorController@getByAuth');
});
