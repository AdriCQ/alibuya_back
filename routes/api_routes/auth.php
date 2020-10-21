<?php

use Illuminate\Support\Facades\Route;

Route::namespace('App\Http\Controllers\Auth')->group(function () {
  Route::post('/login', 'AuthController@login');
  Route::post('/register', 'AuthController@register');
});
