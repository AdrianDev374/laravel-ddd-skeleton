<?php

declare(strict_types=1);

namespace Company\Shared\Infrastructure\Bus\Event;

final class DomainEventListenerMapper
{
    private array $eventsWithListeners = [];

    public function __construct(private readonly array $listeners)
    {
        $this->mapper();
    }

    public function listenersForEvent(string $event): array
    {
        return $this->eventsWithListeners[$event];
    }

    private function mapper(): void
    {
        foreach ($this->listeners as $listener) {
            $events = $listener::listenTo();
            foreach ($events as $event) {
                $this->eventsWithListeners[$event][] = $listener;
            }
        }
    }
}
