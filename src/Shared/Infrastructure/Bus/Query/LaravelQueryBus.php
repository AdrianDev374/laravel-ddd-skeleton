<?php

declare(strict_types=1);

namespace Company\Shared\Infrastructure\Bus\Query;

use Company\Shared\Domain\Bus\Query\Query;
use Company\Shared\Domain\Bus\Query\QueryBus;
use Company\Shared\Domain\Bus\Query\QueryResponse;
use Illuminate\Bus\Dispatcher;

final class LaravelQueryBus implements QueryBus
{
    public function __construct(private readonly Dispatcher $dispatcher)
    {
    }

    public function ask(Query $query): QueryResponse
    {
        return $this->dispatcher->dispatchNow($query);
    }
}
