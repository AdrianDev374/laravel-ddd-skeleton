<?php

declare(strict_types=1);

namespace Company\Shared\Infrastructure\Laravel;

use Company\Shared\Domain\Bus\Command\Command;
use Company\Shared\Domain\Bus\Command\CommandBus;
use Company\Shared\Domain\Bus\Query\Query;
use Company\Shared\Domain\Bus\Query\QueryBus;
use Company\Shared\Domain\Bus\Query\QueryResponse;
use Company\Shared\Infrastructure\Exceptions\ExceptionMapper;

abstract class BaseController
{
    public function __construct(
        private readonly CommandBus $commandBus,
        private readonly QueryBus $queryBus,
        private readonly ExceptionMapper $exceptionMapper
    ) {
        foreach ($this->exceptions() as $exception => $statusCode) {
            $this->exceptionMapper->map($exception, $statusCode);
        }
    }

    abstract protected function exceptions(): array;

    final protected function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }

    final protected function ask(Query $query): ?QueryResponse
    {
        return $this->queryBus->ask($query);
    }
}
