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
    public $vars;

    public function __construct()
    {
        if (isset(Config::$user)) {
            $this->vars['user'] = Config::$user->getUser();
        }

        if (Skin::$view == null) {
            Skin::$view = new View($this);
        }
    }

    public function run()
    {
        var_dump($this);
        Skin::$view->run($this->vars);
    }
}
