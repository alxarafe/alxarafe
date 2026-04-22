<?php

declare(strict_types=1);

namespace Alxarafe\Infrastructure\Adapter;

use Alxarafe\Infrastructure\Lib\Trans;
use Alxarafe\ResourceController\Contracts\TranslatorContract;

/**
 * AlxarafeTranslator — Bridges Trans::_() to TranslatorContract.
 */
class AlxarafeTranslator implements TranslatorContract
{
    public function translate(string $key, array $params = []): string
    {
        return Trans::_($key, $params);
    }
}
