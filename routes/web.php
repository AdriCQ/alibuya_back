<?php

use App\Mail\OrderShipped;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Mail;
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
	return view('welcome');
});

Route::get('/test', function () {
	Mail::to("adrian@localhost")->send(new OrderShipped());
});

Route::get('/login', function () {
	return response()->json(['STATUS' => false, 'ERRORS' => ['Error de auntenticación']]);
})->name('login');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
	$request->fulfill();

	return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');
