<?php

declare(strict_types=1);

namespace Company\Shared\Domain;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use InvalidArgumentException;
use RuntimeException;

final class Utils
{
    public static function jsonEncode(array $data): string
    {
        return json_encode($data);
    }

    public static function jsonDecode(string $json): array
    {
        $values = json_decode($json, true);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new RuntimeException('Could not parse JSON => ' . json_last_error());
        }

        return $values;
    }

    public static function dateToString(DateTimeInterface $date): string
    {
        return $date->format(DateTimeInterface::ATOM);
    }

    public static function stringToDate(string $date): DateTimeImmutable
    {
        try {
            return new DateTimeImmutable($date);
        } catch (Exception) {
            throw new InvalidArgumentException("Date <$date> is not valid");
        }
    }

}
