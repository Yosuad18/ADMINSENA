<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\ComputerController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\ApprenticeController;
use App\Http\Controllers\TrainingCenterController;



Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/quienes-somos', [PublicController::class, 'about'])->name('about');
Route::get('/programas', [PublicController::class, 'programs'])->name('programs');


Route::get('/noticias', [PublicController::class, 'news'])->name('news.index');
Route::get('/noticias/{slug}', [PublicController::class, 'newsDetail'])->name('news.show');

Route::get('/eventos', [PublicController::class, 'events'])->name('events');


Route::get('/contacto', [PublicController::class, 'contact'])->name('contact');
Route::post('/contacto', [PublicController::class, 'submitContact'])->name('contact.submit');


Route::get('/buscar', [PublicController::class, 'search'])->name('search');

Route::post('/chat', [ChatController::class, 'send'])
    ->middleware('throttle:10,1')
    ->name('chat.send');


Route::get('/acceso', [AuthController::class, 'showLogin'])->name('login');
Route::post('/acceso', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/salir', [AuthController::class, 'logout'])->name('logout');



Route::get('/ir-al-panel', [PublicController::class, 'adminPanel'])
    ->middleware('auth')
    ->name('admin.panel');

Route::middleware('auth')->group(function () {
    Route::resource('areas', AreaController::class);
    Route::resource('computers', ComputerController::class);
    Route::resource('training-centers', TrainingCenterController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('courses', CourseController::class);
    Route::resource('apprentices', ApprenticeController::class);
});
