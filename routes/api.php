Route::get('/apprentices', [ApprenticeController::class, 'index']);
Route::post('/apprentices', [ApprenticeController::class, 'store']);
Route::put('/apprentices/{apprentice}', [ApprenticeController::class, 'update']);
Route::delete('/apprentices/{apprentice}', [ApprenticeController::class, 'destroy']);
