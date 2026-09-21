<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\ApprenticeController;
use App\Http\Controllers\ComputerController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TrainingCenterController;

Route::get('/areas', [AreaController::class, 'index']);
Route::post('/areas', [AreaController::class, 'store']);
Route::delete('/areas', [AreaController::class, 'store']);


Route::get('/apprentices', [ApprenticeController::class, 'index']);
Route::post('/apprentices', [ApprenticeController::class, 'store']);
Route::post('/apprentices', [ApprenticeController::class, 'store']);


Route::get('/computers', [ComputerController::class, 'index']);
Route::post('/computers', [ComputerController::class, 'store']);
Route::delete('/computers', [ComputerController::class, 'store']);


Route::get('/courses', [CourseController::class, 'index']);
Route::post('/courses', [CourseController::class, 'store']);
Route::delete('/courses', [CourseController::class, 'store']);


Route::get('/teachers', [TeacherController::class, 'index']);
Route::post('/teachers', [TeacherController::class, 'store']);
Route::delete('/teachers', [TeacherController::class, 'store']);


Route::get('/training-centers', [TrainingCenterController::class, 'index']);
Route::post('/training-centers', [TrainingCenterController::class, 'store']);
Route::delete('/training-centers', [TrainingCenterController::class, 'store']);
