<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Controllers;

use Alxarafe\Base\Controller;
use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Auth;
use Alxarafe\Helpers\Skin;
use Alxarafe\Helpers\Debug;

class EditConfig extends Controller
{

    public function __construct()
    {
        parent::__construct();
        Skin::setTemplate('dbconfig');
    }
}
