<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;

Broadcast::routes(['middleware' => ['auth:sanctum']]);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

Route::middleware('auth:sanctum')
    ->group(static function () {
        Route::get('/users', [UserController::class, 'index']);
        Route::get('/user', [UserController::class, 'show']);

        Route::apiResource('chats', ChatController::class)
            ->except(['show', 'update']);

        Route::apiResource('messages', MessageController::class)
            ->only(['store', 'update', 'destroy']);
    });
