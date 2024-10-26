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

Route::group(['namespace' => 'App\Http\Controllers\Backend', 'middleware' => ['api', 'auth:sanctum']], function () {
    Route::apiResource('hospitals', 'HospitalController');
    Route::post('hospitals/{hospital}/{status}', 'HospitalController@activation')->where('status', 'active|inactive');
});

Route::prefix('patient')->middleware(['api', 'auth:sanctum'])->namespace('App\Http\Controllers\Frontend')->group(function () {
    Route::put('profile', 'ProfileController@update');
    Route::get('profile', 'ProfileController@show');
});
Route::apiResource('omer/hospitals', 'App\Http\Controllers\Frontend\HospitalController')->only(['index', 'show']);
