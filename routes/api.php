<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\Frontend\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthenticationController::class, 'login']);
    Route::post('register', [AuthenticationController::class,'register']);

    Route::middleware(['web'])->group(function () {
        Route::get('{provider}/redirect', [AuthenticationController::class, 'redirect']);
        Route::get('{provider}/callback', [AuthenticationController::class, 'callback']);
    });

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('logout', [AuthenticationController::class,'logout']);
        Route::post('verification-code', [AuthenticationController::class, 'sendVerificationCode']);
        Route::post('verify-verification-code', [AuthenticationController::class, 'verifyVerificationCode']);
    });
});

Route::prefix('patient')->middleware(['api', 'auth:sanctum'])->group(function () {
    Route::put('profile', [ProfileController::class, 'update']);
});
