<?php

declare(strict_types=1);

namespace Company\Apps\Shared\Providers;

use Company\Shared\Domain\Bus\Command\CommandBus;
use Company\Shared\Domain\Bus\Query\QueryBus;
use Company\Shared\Infrastructure\Bus\Command\LaravelCommandBus;
use Company\Shared\Infrastructure\Bus\Query\LaravelQueryBus;
use Company\Shared\Infrastructure\Bus\TransactionModeCommand;
use Company\Shared\Infrastructure\Exceptions\ExceptionMapper;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;

final class SharedServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->singleton(ExceptionMapper::class, fn() => new ExceptionMapper());
        $this->app->bind(CommandBus::class, LaravelCommandBus::class);
        $this->app->bind(QueryBus::class, LaravelQueryBus::class);
        Bus::pipeThrough([TransactionModeCommand::class]);
    }
}
