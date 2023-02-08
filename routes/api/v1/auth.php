<?php

use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\UserController;
use App\Providers\RouteServiceProvider as RSP;
use Illuminate\Support\Facades\Route;

/**
 * Auth
 */
Route::controller(AuthController::class) // middlewares are defined in controller
    ->prefix('auth')
    ->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
        Route::post('/logout', 'logout');
        Route::post('/refresh', 'refresh');
        Route::get('/user', 'userProfile');
        Route::get('/', 'test');
        Route::get('/debug', 'debug');
    });

