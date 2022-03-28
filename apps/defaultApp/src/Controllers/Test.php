<?php

declare(strict_types=1);

namespace Company\Apps\DefaultApp\Controllers;

use Company\Shared\Domain\Exceptions\InvalidUuid;
use Company\Shared\Domain\ValueObjects\Uuid;
use Company\Shared\Infrastructure\Bus\Event\DomainEventListenerMapper;
use Company\Shared\Infrastructure\Bus\Event\DomainEventMapper;
use Company\Shared\Infrastructure\Laravel\BaseController;
use Symfony\Component\HttpFoundation\Response;

final class Test extends BaseController
{
    public function __invoke(DomainEventListenerMapper $domainEventMapper)
    {
        $asd = new Uuid('234');
        echo config('app.name');
        return "hola bb";
    }

    protected function exceptions(): array
    {
        return [
            InvalidUuid::class => Response::HTTP_NOT_FOUND
        ];
    }
}
