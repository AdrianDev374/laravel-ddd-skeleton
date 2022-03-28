<?php

declare(strict_types=1);

namespace Company\Shared\Domain\Exceptions;

use RuntimeException;

final class EventNotMapped extends RuntimeException
{
    public function __construct(string $eventName)
    {
        parent::__construct("The domain event for <$eventName> doesn't exists or haven't listener");
    }
}
