<?php

declare(strict_types=1);

namespace Company\Shared\Domain\Exceptions;

use RuntimeException;

final class InvalidUuid extends RuntimeException implements DomainException
{
    public function __construct(string $uuid)
    {
        parent::__construct("The uuid <$uuid> is not valid");
    }
}
