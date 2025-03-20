<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\TwilioService;
use App\Services\ImageService;
use Illuminate\Routing\Router;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TwilioService::class, function ($app) {
            return new TwilioService();
        });

        $this->app->singleton(ImageService::class, function ($app) {
            return new ImageService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Router $router): void
    {
        $router->aliasMiddleware('jwt.verify', \App\Http\Middleware\JwtMiddleware::class);
        $router->aliasMiddleware('jwt.auth', \PHPOpenSourceSaver\JWTAuth\Http\Middleware\Authenticate::class);
    }
}
