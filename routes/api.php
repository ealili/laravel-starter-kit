<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    Route::post('/login', 'login');
});

Route::middleware(['auth:sanctum', 'can:manage_users'])->group(function () {
    Route::controller(UserController::class)
        ->prefix('users')
        ->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
        });
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::controller(UserController::class)
        ->prefix('users')
        ->group(function () {
            Route::post('/', 'store');
        });
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

