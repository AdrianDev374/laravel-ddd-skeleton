<?php

declare(strict_types=1);

namespace Company\Shared\Domain\ValueObjects;

class IntValueObject
{
    public function __construct(private readonly int $value)
    {
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
