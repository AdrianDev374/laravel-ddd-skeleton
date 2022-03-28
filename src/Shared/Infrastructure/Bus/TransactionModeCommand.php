<?php

declare(strict_types=1);

namespace Company\Shared\Infrastructure\Bus;

use Closure;
use Company\Shared\Domain\Bus\Command\Command;
use Illuminate\Support\Facades\DB;

final class TransactionModeCommand
{
    public function handle($executable, Closure $next)
    {
        return $executable instanceof Command ? DB::transaction(fn() => $next($executable), 3) : $next($executable);
    }
}
