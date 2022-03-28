<?php

declare(strict_types=1);

namespace Company\Apps\DefaultApp;

use Illuminate\Foundation\Http\Kernel;

final class DefaultAppKernel extends Kernel
{
    protected $middleware = [
        // \Company\Apps\Shared\Middleware\TrustHosts::class,
        \Company\Apps\Shared\Middlewares\TrustProxies::class,
        \Illuminate\Http\Middleware\HandleCors::class,
        \Company\Apps\Shared\Middlewares\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Company\Apps\Shared\Middlewares\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class
    ];

    protected $middlewareGroups = [
        'api' => [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class
        ]
    ];

    protected $routeMiddleware = [
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
    ];
}
