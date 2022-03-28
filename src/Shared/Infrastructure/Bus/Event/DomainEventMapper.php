<?php

declare(strict_types=1);

namespace Company\Shared\Infrastructure\Bus\Event;

use Company\Shared\Domain\Exceptions\EventNotMapped;

final class DomainEventMapper
{
    private array $listenersMapped = [];

    public function __construct(private array $listeners)
    {
        $this->mapper();
    }

    public function for(string $eventName): string
    {
        if (false === isset($this->listenersMapped[$eventName])) {
            throw new EventNotMapped($eventName);
        }

        return $this->listenersMapped[$eventName];
    }

    private function mapper(): void
    {
        foreach ($this->listeners as $listener) {
            $events = $listener::listenTo();
            foreach ($events as $event) {
                $this->listenersMapped[$event::eventName()] = $event;
            }
        }
    }
}
