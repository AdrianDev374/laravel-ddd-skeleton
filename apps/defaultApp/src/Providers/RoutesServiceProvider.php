<?php

declare(strict_types=1);

namespace Company\Apps\DefaultApp\Providers;

use Company\Apps\DefaultApp\DefaultApp;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Finder\Finder;

final class RoutesServiceProvider extends RouteServiceProvider
{
    public function boot()
    {
        $this->configureRateLimiting();
        $this->loadAppRoutes();
    }

    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    private function loadAppRoutes(): void
    {
        $this->routes(function () {
            foreach (Finder::create()->files()->in(base_path('routes/api')) as $file) {
                Route::prefix(DefaultApp::APP_PREFIX)
                    ->middleware('api')
                    ->namespace($this->namespace)
                    ->group(base_path("routes/api/{$file->getRelativePathname()}"));
            }

            foreach (Finder::create()->files()->in(base_path('routes/web')) as $file) {
                Route::middleware('web')
                    ->namespace($this->namespace)
                    ->group(base_path("routes/web/{$file->getRelativePathname()}"));
            }
        });
    }
}
