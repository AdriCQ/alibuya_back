<?php

use App\Mail\Auth\RegisterMail;
use App\Mail\Auth\ResetPassword;
use App\Models\User\User;
use Faker\Factory;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
	return redirect(\App\Models\AppSettings::$CLIENT_URL);
});

Route::get('/login', function () {
	return redirect(\App\Models\AppSettings::$CLIENT_URL);
})->name('login');


Route::prefix('/email-test')->group(function () {
	Route::get('/email-verify', function () {
		$faker = Factory::create();
		return (new RegisterMail(User::query()->first(), $faker->url));
	});

	Route::get('/password-reset', function () {
		$faker = Factory::create();
		return (new ResetPassword(User::query()->first(), $faker->password));
	});
});
