<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Helpers;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class TwigFilters.
 *
 * @package Alxarafe\Core\Helpers
 */
class TwigFilters extends AbstractExtension
{
    /**
     * Return a list of filters.
     *
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('test', [$this, 'test']),
        ];
    }

    /**
     * A sample filter.
     *
     * @return string
     */
    public function test(): string
    {
        return 'test';
    }
}
