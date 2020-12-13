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
  Route::get('/verify-email', 'AuthController@verifyEmail');
  Route::get('/resend-verification-email', 'AuthController@resendEmailConfirmation');
  Route::post('/password-reset', 'AuthController@resetPassword');
  Route::get('/password-reset', 'AuthController@sendResetPasswordEmail');

  Route::middleware('auth:sanctum')->group(function () {
    Route::get('/roles', 'UserController@getRoles');
  });
});
