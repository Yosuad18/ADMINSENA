<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController; 

Route::get('/areas', [AreaController::class, 'index']);
Route::post('/areas', [AreaController::class, 'store']);
