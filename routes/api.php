<?php

use App\Http\Controllers\Authentication\AuthenticationController;
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

Route::middleware('guest')->group(function () {


    Route::post('register', [AuthenticationController::class, 'register']);
    Route::post('login', [AuthenticationController::class, 'login']);

    Route::post('forgot-password', [AuthenticationController::class, 'password_reset_link'])
        ->name('password.email');

    Route::post('reset-password', [AuthenticationController::class, 'reset_password'])
        ->name('password.reset');
});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('logout', [AuthenticationController::class, 'logout'])
        ->name('logout');
});
