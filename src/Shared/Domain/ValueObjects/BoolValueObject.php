<?php

declare(strict_types=1);

namespace Company\Shared\Domain\ValueObjects;

class BoolValueObject
{
    public function __construct(private readonly bool $value)
    {
    }

    public function getValue(): bool
    {
        return $this->value;
    }
}
