

Route::get('/computers', [ComputerController::class, 'index']);
Route::post('/computers', [ComputerController::class, 'store']);

