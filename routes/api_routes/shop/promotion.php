<?php

use Illuminate\Support\Facades\Route;

Route::group(function () {
  Route::get('/', 'PromotionController@promotions');
  Route::get('/active', 'PromotionController@availablePromotions');
  Route::get('/by-tags', 'PromotionController@promotionsByTags');
});
