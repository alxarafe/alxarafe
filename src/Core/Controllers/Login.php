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
use Alxarafe\Views\Login as LoginView;

class Login extends Controller
{

    public function __construct()
    {
        parent::__construct();

        if (isset($_POST['login'])) {
            if (Config::$user->setUser($_POST['username'], $_POST['password'])) {
                header('Location: ' . BASE_URI);
            }
            Config::setError('User authentication error. Please check the username and password.');
        }
    }

    public function run()
    {
        Skin::setView(new LoginView($this));
        //header('Location: ' . BASE_URI);
    }

    public function off()
    {
        Config::$user->logout();
        header('Location: ' . BASE_URI);
    }
}
