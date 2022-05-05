<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::apiResource('user', UserController::class)->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');

    Route::post('/me', 'me')->middleware(['auth:sanctum']);
    Route::post('/status', 'status')->middleware('auth:sanctum');
});

Route::get('/tess', function(\Illuminate\Http\Request $request) {
    return response()->json([
        'data' => $request->all()
    ], 200);
})->middleware(['verified_phone', 'auth:sanctum']);
