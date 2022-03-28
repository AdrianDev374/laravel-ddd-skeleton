<?php

declare(strict_types=1);

namespace Company\Shared\Domain\ValueObjects;

use Company\Shared\Domain\Exceptions\InvalidUuid;
use Illuminate\Support\Str;

class Uuid
{
    public function __construct(private readonly string $value)
    {
        $this->ensureIsUuid($this->value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public static function generate(): self
    {
        return new self(Str::uuid()->toString());
    }

    private function ensureIsUuid(string $value): void
    {
        /**
         * We assume infrastructure leak at this current point
         */
        if (false === Str::isUuid($value)) {
            throw new InvalidUuid($value);
        }
    }
}
