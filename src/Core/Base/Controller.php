<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Base;

use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Debug;
use Alxarafe\Helpers\Session;
use ReflectionClass;

/**
 * Class Controller
 *
 * @package Alxarafe\Base
 */
class Controller
{
    /**
     * TODO: Undocumented
     *
     * @var null
     */
    public $username;

    /**
     * Class short name.
     *
     * @var string
     */
    public $shortName;

    /**
     * @var Session
     */
    public $session;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $this->session = Config::$session->getSingleton();
        $this->shortName = (new ReflectionClass($this))->getShortName();
        Debug::startTimer($this->shortName, $this->shortName . ' Controller Constructor');
        $this->username = null;
        Debug::stopTimer($this->shortName);
    }

    /**
     * Start point
     *
     * @return void
     */
    public function index(): void
    {
    }
}
