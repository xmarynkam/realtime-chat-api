<?php

use App\Http\Controllers\CsrfCookieController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('csrf-cookie', [CsrfCookieController::class])
    ->name('csrf_cookie');
