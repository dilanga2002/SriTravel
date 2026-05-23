<?php

namespace App\Providers;

use App\Services\ImageUploadService;
use App\Services\ProfileService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
{
    $this->app->singleton(ImageUploadService::class, function ($app) {
        return new ImageUploadService();
    });

    $this->app->singleton(ProfileService::class, function ($app) {
        return new ProfileService($app->make(ImageUploadService::class));
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