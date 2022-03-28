<?php

use Company\Apps\DefaultApp\DefaultApp;
use Company\Apps\DefaultApp\DefaultAppConsoleKernel;
use Company\Apps\DefaultApp\DefaultAppKernel;
use Company\Shared\Infrastructure\Exceptions\BaseException;

$app = new DefaultApp($_ENV['APP_BASE_PATH'] ?? dirname(__DIR__));
$app->singleton(Illuminate\Contracts\Http\Kernel::class, DefaultAppKernel::class);
$app->singleton(Illuminate\Contracts\Console\Kernel::class, DefaultAppConsoleKernel::class);
$app->singleton(Illuminate\Contracts\Debug\ExceptionHandler::class, BaseException::class);
return $app;
