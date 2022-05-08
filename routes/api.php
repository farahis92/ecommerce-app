<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Responses\Respond;
use Illuminate\Support\Facades\Route;


Route::apiResource('user', UserController::class)->middleware('auth:sanctum');

Route::controller(AuthController::class)->middleware('guest:sanctum')->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
});

Route::controller(AuthController::class)
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::post('/me', 'me');
        Route::post('/status', 'status');
        Route::post('/otp/phone', 'otpPhone')->middleware('unverified_phone');
        Route::post('/otp/email', 'otpEmail')->middleware('unverified_phone');
    });


Route::get('/test', [AuthController::class, 'test']);
