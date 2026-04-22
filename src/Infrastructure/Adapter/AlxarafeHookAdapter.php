<?php

declare(strict_types=1);

namespace Alxarafe\Infrastructure\Adapter;

use Alxarafe\Infrastructure\Service\HookService;
use Alxarafe\ResourceController\Contracts\HookContract;

/**
 * AlxarafeHookAdapter — Bridges HookService to HookContract.
 */
class AlxarafeHookAdapter implements HookContract
{
    public function execute(string $hookName, mixed ...$args): array
    {
        return HookService::execute($hookName, ...$args);
    }

    public function filter(string $hookName, mixed $value, mixed ...$args): mixed
    {
        return HookService::filter($hookName, $value, ...$args);
    }
}
