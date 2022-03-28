<?php

declare(strict_types=1);

namespace Company\Shared\Infrastructure\Exceptions;

use Company\Shared\Domain\Exceptions\InvalidUuid;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final class ExceptionMapper
{
    private const DEFAULT_STATUS_CODE = Response::HTTP_INTERNAL_SERVER_ERROR;
    private array $exceptions = [
        InvalidArgumentException::class => Response::HTTP_BAD_REQUEST,
        NotFoundHttpException::class => Response::HTTP_NOT_FOUND,
        InvalidUuid::class => Response::HTTP_BAD_REQUEST
    ];

    public function map(string $exception, int $statusCode): void
    {
        $this->exceptions[$exception] = $statusCode;
    }

    public function statusCodeFor(string $exception): int
    {
        return $this->exceptions[$exception] ?? self::DEFAULT_STATUS_CODE;
    }
}
