<?php

use App\Http\Controllers\v1\JokeController;
use App\Providers\RouteServiceProvider as RSP;
use Illuminate\Support\Facades\Route;

/**
 * Auth
 */
Route::controller(JokeController::class) // middlewares are defined in controller
    ->prefix('joke')
    ->group(function () {
        Route::get('/', 'get');
    });
