<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CsrfCookieController;
use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/user', static function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

Route::middleware('auth:sanctum')
    ->group(static function () {
        Route::apiResource('chats', ChatController::class)
            ->except(['show', 'update']);

        Route::apiResource('messages', MessageController::class)
            ->only(['store', 'update', 'destroy']);
    });
