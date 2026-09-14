<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouterServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
       $this->ApiRoutes();
    }

    public function ApiRoutes(): void
    {
        Route::prefix('api/v1')
            ->middleware('api')
            ->group(base_path('routes/api.php'));
    }
}
