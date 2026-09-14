use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArController;

Route::get('/areas', [AreaController::class, 'index']);
Route::post('/areas', [AreaController::class, 'store']);
