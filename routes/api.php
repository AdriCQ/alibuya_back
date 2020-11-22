<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
  return response()->json($request);
});
Route::post('/', function (Request $request) {
  return response()->json($request);
});

Route::prefix('/location')->group(__DIR__ . '/api_routes/location.php');
Route::prefix('/user')->group(__DIR__ . '/api_routes/user.php');
Route::prefix('/shop')->group(__DIR__ . '/api_routes/shop.php');
Route::prefix('/vendor')->group(__DIR__ . '/api_routes/vendor.php');
