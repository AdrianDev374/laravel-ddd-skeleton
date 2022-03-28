<?php

declare(strict_types=1);

namespace Company\Apps\DefaultApp\Providers;

use Company\Apps\DefaultApp\DefaultApp;
use Company\Shared\Infrastructure\Bus\Event\DomainEventListenerMapper;
use Company\Shared\Infrastructure\Bus\Event\DomainEventMapper;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

final class AppServiceProvider extends ServiceProvider
{
    private array $listeners = [];

    public function boot(): void
    {
        $this->loadAppConfiguration();
    }

    private function loadAppConfiguration(): void
    {
        $paths = array_map($this->convertToRoute(), DefaultApp::BOUNDED_CONTEXTS);
        foreach (Finder::create()->files()->name('module.yaml')->in($paths) as $file) {
            $configModule = Yaml::parseFile($file->getRealPath());

            // Bind Interfaces
            $interfaces = $configModule['interfaces'] ?? [];
            array_walk(
                $interfaces,
                fn(string $concrete, string $abstract) => $this->app->bind($abstract, $concrete)
            );

            // Bind Queries
            $queries = $configModule['queries'] ?? [];
            array_walk(
                $queries,
                fn(string $handler, string $query) => Bus::map([$query => $handler])
            );

            // Bind Commands
            $commands = $configModule['commands'] ?? [];
            array_walk(
                $commands,
                fn(string $handler, string $command) => Bus::map([$command => $handler])
            );

            // Bind Listeners
            $listeners = $configModule['listeners'] ?? [];
            array_walk(
                $listeners,
                fn(string $listener) => $this->listeners[] = $listener
            );
        }
        $this->app->singleton(DomainEventMapper::class, fn() => new DomainEventMapper($this->listeners));
        $this->app->singleton(
            DomainEventListenerMapper::class,
            fn() => new DomainEventListenerMapper(array_map($this->makeListener(), $this->listeners))
        );
    }

    private function makeListener(): callable
    {
        return function (string $listener): mixed {
            return $this->app->make($listener);
        };
    }

    private function convertToRoute(): callable
    {
        return function (string $boundedContext): string {
            return base_path("../../src/$boundedContext");
        };
    }
}
