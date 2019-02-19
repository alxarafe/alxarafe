<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Helpers;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class TwigFilters.
 *
 * @package Alxarafe\Helpers
 */
class TwigFilters extends AbstractExtension
{
    /**
     * Return a list of filters.
     *
     * @return \Twig_SimpleFilter[]
     */
    public function getFilters()
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
