<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::apiResource('user', UserController::class)->middleware('auth:sanctum');

Route::controller(AuthController::class)->middleware('guest:sanctum')->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
});

Route::controller(AuthController::class)->middleware(['auth:sanctum','verified_phone'])->group(function () {
    Route::post('/me', 'me');
    Route::post('/status', 'status');
    Route::post('/otp', 'otp')->withoutMiddleware('verified_phone')->middleware('unverified_phone');
});
