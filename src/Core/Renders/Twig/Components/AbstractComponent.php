<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Renders\Twig\Components;

/**
 * Abstract Class component
 *
 * @package Alxarafe
 */
abstract class AbstractComponent
{

    public function __construct($parameters)
    {
        var_dump($parameters);
    }

    public function toHtml(): string
    {
        return '<p>Ok</p>';
    }
}
