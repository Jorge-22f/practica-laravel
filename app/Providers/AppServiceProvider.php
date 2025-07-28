<?php

namespace App\Providers;

use App\Business\Interfaces\MessageServiceInterface;
use App\Business\services\EncryptorService;
use App\Business\services\HiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(MessageServiceInterface::class, HiService::class);
        $this->app->bind(EncryptorService::class, function(){
            return new EncryptorService(env("kEY_ENCRYPT"));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
