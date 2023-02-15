<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', 'App\Http\Controllers\AuthLoginController@login');
Route::post('register', 'App\Http\Controllers\AuthRegisterController@register');
Route::post('forgot-password', 'App\Http\Controllers\AuthForgotPasswordController@sendResetLinkEmail');
Route::post('reset-password', 'App\Http\Controllers\AuthResetPasswordController@reset')->name('password.reset');

// Route::post('login', 'App\Http\Controllers\AuthController@login');
// Route::post('register', 'App\Http\Controllers\AuthController@register');
// Route::post('forgot-password', 'App\Http\Controllers\AuthController@forgotPassword');
// Route::post('reset-password', 'App\Http\Controllers\AuthController@resetPassword');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
