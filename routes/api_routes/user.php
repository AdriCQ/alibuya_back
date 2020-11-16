<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers\User')->group(function () {

  /**
   * -----------------------------------------
   *	Auth Routes
   * -----------------------------------------
   */
  Route::post('/login', 'AuthController@login');
  Route::post('/register', 'AuthController@register');

  Route::middleware('auth:sanctum')->group(function () {
    Route::get('/roles', 'UserController@getRoles');
  });
});
