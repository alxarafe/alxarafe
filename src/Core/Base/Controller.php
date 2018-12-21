<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Base;

use Alxarafe\Base\View;
use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Skin;

class Controller
{

    public $user;

    public function __construct()
    {
        //echo "<p>En constructor de Controller</p>";
    }

    public function run(array $vars = [])
    {
        $vars['user'] = Config::$user->getUser();
        if (Skin::$view == null) {
            Skin::$view = new View($this);
        }

        Skin::$view->run($vars);
    }
}
