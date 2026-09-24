<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ComputerController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ApprenticeController;
use App\Http\Controllers\TrainingCenterController;

Route::middleware('auth')->group(function () {
    Route::resource('areas', AreaController::class);
    Route::resource('computers', ComputerController::class);
    Route::resource('training-centers', TrainingCenterController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('courses', CourseController::class);
    Route::put('courses/{course}/image', [CourseController::class, 'updateImage'])->name('courses.updateImage');
    Route::resource('apprentices', ApprenticeController::class);
});

Route::post('/acceso', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/salir', [AuthController::class, 'logout'])->name('logout');

Route::get('/api/user', function () {
    if (auth()->check()) {
        return response()->json([
            'id'    => auth()->id(),
            'name'  => auth()->user()->name,
            'email' => auth()->user()->email,
        ]);
    }
    return response()->json(null, 401);
});

Route::get('/{any?}', function () {
    return view('welcome');
})->where('any', '.*');
