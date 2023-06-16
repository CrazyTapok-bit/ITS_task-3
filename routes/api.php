<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\ReminderController;
use App\Http\Controllers\Api\UserController;
use App\Http\Middleware\TgLoginWidget;
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

Route::prefix('auth')
    ->middleware('api')
    ->group(function() {
        Route::post('register', [UserController::class, 'store']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
    });

Route::middleware('auth:api')->group(function() {
    /** User */
    Route::post('user/subscribe', [UserController::class, 'subscribe'])->middleware(TgLoginWidget::class);
    Route::apiResource('user', UserController::class)->only(['update']);

    /** Event */
    Route::put('event/{id}/complete', [EventController::class, 'complete']);
    Route::apiResource('event', EventController::class)->only(['index', 'store', 'update', 'destroy']);

    /** Reminder */
    Route::apiResource('reminder', ReminderController::class)->only(['index', 'store']);
});
