<?php

declare(strict_types=1);

namespace Company\Shared\Domain\Bus\Event;

interface DomainEventListener
{
    public static function listenTo(): array;
}
