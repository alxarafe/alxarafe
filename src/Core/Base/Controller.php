<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Base;

use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Skin;

/**
 * Class Controller
 *
 * @package Alxarafe\Base
 */
class Controller
{

    /**
     * TODO: Undocummented
     *
     * @var
     */
    public $user;

    /**
     * TODO: Undocummented
     *
     * @var
     */
    public $vars;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        if (isset(Config::$user)) {
            $this->vars['user'] = Config::$user->getUser();
        }

        /*
          if (Skin::$view == null) {
          Skin::$view = new View($this);
          }
         */
    }

    /**
     * TODO: Undocummented
    public function _run()
    {
        Skin::$view->run($this->vars);
    }
     */
}
