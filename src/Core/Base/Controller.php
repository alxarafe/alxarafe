<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Base;

use Alxarafe\Helpers\Debug;
use ReflectionClass;

/**
 * Class Controller
 *
 * @package Alxarafe\Base
 */
class Controller
{
    public $username;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $shortName = (new ReflectionClass($this))->getShortName();
        Debug::startTimer($shortName, $shortName . ' Controller Constructor');
        $this->username = null;
        Debug::stopTimer($shortName);
    }

    /**
     * Start point
     */
    public function index()
    {
    }
}
