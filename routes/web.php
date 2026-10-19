<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
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
Route::post('/programas/inscripcion', [PublicController::class, 'register'])->name('programs.register');


Route::get('/noticias', [PublicController::class, 'news'])->name('news.index');
Route::get('/noticias/{slug}', [PublicController::class, 'newsDetail'])->name('news.show');

Route::get('/eventos', [PublicController::class, 'events'])->name('events');


Route::get('/contacto', [PublicController::class, 'contact'])->name('contact');
Route::post('/contacto', [PublicController::class, 'submitContact'])->name('contact.submit');


Route::get('/buscar', [PublicController::class, 'search'])->name('search');

Route::post('/chat', [ChatController::class, 'send'])
    ->middleware('throttle:10,1')
    ->name('chat.send');


Route::get('/ir-al-panel', [AdminController::class, 'index'])->name('admin.panel');

Route::get('product/pepe', [CourseController::class, 'create']);

Route::resource('areas', AreaController::class);
Route::resource('computers', ComputerController::class);
Route::resource('training-centers', TrainingCenterController::class);
Route::resource('teachers', TeacherController::class);
Route::resource('courses', CourseController::class);
Route::put('courses/{course}/image', [CourseController::class, 'updateImage'])->name('courses.updateImage');
Route::resource('apprentices', ApprenticeController::class);
