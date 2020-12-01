<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers\Shop')->group(function () {
  Route::get('/', 'PromotionController@promotions');
  Route::get('/active', 'PromotionController@availablePromotions');
});
