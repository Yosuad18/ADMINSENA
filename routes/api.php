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
Route::get('/areas/{area}', [AreaController::class, 'show']);
Route::put('/areas/{area}', [AreaController::class, 'update']);
Route::delete('/areas/{area}', [AreaController::class, 'destroy']);


Route::get('/apprentices', [ApprenticeController::class, 'index']);
Route::post('/apprentices', [ApprenticeController::class, 'store']);
Route::get('/apprentices/{apprentice}', [ApprenticeController::class, 'show']);
Route::put('/apprentices/{apprentice}', [ApprenticeController::class, 'update']);
Route::delete('/apprentices/{apprentice}', [ApprenticeController::class, 'destroy']);


Route::get('/computers', [ComputerController::class, 'index']);
Route::post('/computers', [ComputerController::class, 'store']);
Route::get('/computers/{computer}', [ComputerController::class, 'show']);
Route::put('/computers/{computer}', [ComputerController::class, 'update']);
Route::delete('/computers/{computer}', [ComputerController::class, 'destroy']);


Route::get('/courses', [CourseController::class, 'index']);
Route::post('/courses', [CourseController::class, 'store']);
Route::get('/courses/{course}', [CourseController::class, 'show']);
Route::put('/courses/{course}', [CourseController::class, 'update']);
Route::delete('/courses/{course}', [CourseController::class, 'destroy']);


Route::get('/teachers', [TeacherController::class, 'index']);
Route::post('/teachers', [TeacherController::class, 'store']);
Route::get('/teachers/{teacher}', [TeacherController::class, 'show']);
Route::put('/teachers/{teacher}', [TeacherController::class, 'update']);
Route::delete('/teachers/{teacher}', [TeacherController::class, 'destroy']);


Route::get('/training-centers', [TrainingCenterController::class, 'index']);
Route::post('/training-centers', [TrainingCenterController::class, 'store']);
Route::get('/training-centers/{trainingCenter}', [TrainingCenterController::class, 'show']);
Route::put('/training-centers/{trainingCenter}', [TrainingCenterController::class, 'update']);
Route::delete('/training-centers/{trainingCenter}', [TrainingCenterController::class, 'destroy']);
