<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
  return response()->json($request);
});
Route::post('/', function (Request $request) {
  return response()->json($request);
});

/**
 * -----------------------------------------
 *	Auth Routes
 * -----------------------------------------
 */

Route::prefix('/auth')->group(__DIR__ . '/api_routes/auth.php');
Route::prefix('/shop')->group(__DIR__ . '/api_routes/shop.php');
