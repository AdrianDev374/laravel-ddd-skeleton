<?php

declare(strict_types=1);

namespace Company\Shared\Infrastructure\Bus\Command;

use Company\Shared\Domain\Bus\Command\Command;
use Company\Shared\Domain\Bus\Command\CommandBus;
use Illuminate\Bus\Dispatcher;

final class LaravelCommandBus implements CommandBus
{
    public function __construct(private readonly Dispatcher $dispatcher)
    {
    }

    public function dispatch(Command $command): void
    {
        /**
         * If we want to make a distributed bus, we have to send it to
         * an SQS queue and consume the events with a CLI command
         */
        $this->dispatcher->dispatchNow($command);
    }
}
