<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

class DateComponent extends AbstractEditComponent
{

    public static function test($key, $struct, &$value)
    {
        dump($key);
        dump($struct);
        dump($value);
    }

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/date.html';
    }
}