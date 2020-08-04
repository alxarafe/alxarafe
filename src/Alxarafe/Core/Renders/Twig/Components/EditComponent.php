<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

abstract class EditComponent extends AbstractEditComponent
{

    public static function test($key, $struct, &$value)
    {
        dump($key);
        dump($struct);
        dump($value);
    }
}
