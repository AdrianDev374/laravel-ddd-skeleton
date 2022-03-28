<?php

declare(strict_types=1);

namespace Company\Shared\Infrastructure\Exceptions;

use Company\Shared\Domain\Exceptions\DomainException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use ReflectionClass;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

final class BaseException extends ExceptionHandler
{
    public function __construct(
        Container $container,
        private readonly ExceptionMapper $exceptionMapper
    ) {
        parent::__construct($container);
    }

    public function render(
        $request,
        Throwable $e
    ): \Illuminate\Http\Response|JsonResponse|\Illuminate\Http\JsonResponse|Response {
        if ($e instanceof DomainException) {
            return new JsonResponse(
                [
                    'message' => $e->getMessage(),
                    'exception' => (new ReflectionClass($e))->getShortName()
                ],
                $this->exceptionMapper->statusCodeFor(get_class($e))
            );
        }
        return parent::render($request, $e);
    }
}
