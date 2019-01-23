<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Base;

use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Debug;

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
        $this->username = null;
    }

    /**
     * Start point
     */
    public function run()
    {
    }
}
