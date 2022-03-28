<?php

declare(strict_types=1);

namespace Company\Shared\Domain\Aggregate;

use Company\Shared\Domain\Bus\Event\DomainEvent;

abstract class AggregateRoot
{
    private array $events = [];

    final protected function register(DomainEvent $domainEvent): void
    {
        $this->events[] = $domainEvent;
    }

    final public function launchDomainEvents(): array
    {
        $tmpEvents = $this->events;
        $this->events = [];

        return $tmpEvents;
    }
}
