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
        Debug::startTimer('controller', (new ReflectionClass($this))->getShortName() . ' Constructor');
        $this->username = null;
        Debug::stopTimer('controller');
    }

    /**
     * Start point
     */
    public function index()
    {
    }
}
