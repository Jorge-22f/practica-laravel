<?php

namespace App\Providers;

use App\ExternalService\ApiService;
use App\ExternalService\Events\DataGet;
use App\ExternalService\Listeners\LogDataGet;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(ApiService::class, function($app){
            $url = config("services.api.url");
            return new ApiService($url);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void // se registran posterior a la inyeccion de los servicios, para rutas, vistas, configuracion, eventos, listeners
    {
        Route::get("/api/posts", function(ApiService $apiService){
            return response()->json($apiService->getData());
        });

        Event::listen(DataGet::class, LogDataGet::class); //registrar evento
    }
}
