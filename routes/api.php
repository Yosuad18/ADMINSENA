<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicApiController;
use App\Http\Controllers\ChatController;

Route::get('/config', [PublicApiController::class, 'config']);
Route::get('/programs', [PublicApiController::class, 'programs']);
Route::get('/news', [PublicApiController::class, 'news']);
Route::get('/news/{slug}', [PublicApiController::class, 'newsDetail']);
Route::get('/events', [PublicApiController::class, 'events']);
Route::get('/search', [PublicApiController::class, 'search']);
Route::post('/contact', [PublicApiController::class, 'contact']);
Route::post('/register', [PublicApiController::class, 'register']);
Route::post('/chat', [ChatController::class, 'send'])
    ->middleware('throttle:10,1');
