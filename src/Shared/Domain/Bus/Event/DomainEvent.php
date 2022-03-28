<?php

declare(strict_types=1);

namespace Company\Shared\Domain\Bus\Event;

use Company\Shared\Domain\Utils;
use Company\Shared\Domain\ValueObjects\Uuid;
use DateTimeImmutable;

abstract class DomainEvent
{
    public function __construct(
        private readonly string $aggregateId,
        private ?string $eventId = null,
        private ?string $occurred_at = null
    ) {
        $this->eventId = $this->eventId ?: Uuid::generate()->getValue();
        $this->occurred_at = $this->occurred_at ?: Utils::dateToString(new DateTimeImmutable());
    }

    public function getAggregateId(): string
    {
        return $this->aggregateId;
    }

    public function getEventId(): ?string
    {
        return $this->eventId;
    }

    public function getOccurredAt(): ?string
    {
        return $this->occurred_at;
    }

    abstract public static function eventName(): string;

    abstract public static function fromNatives(
        string $aggregateId,
        array $attributes,
        string $eventId,
        string $occurred_at
    ): self;

    abstract public function toNatives(): array;
}
