<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Controllers;

use Alxarafe\Base\Controller;
use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Skin;
use Alxarafe\Views\LoginView;

/**
 * Class Login
 *
 * @package Alxarafe\Controllers
 */
class Login extends Controller
{

    /**
     * Login constructor.
     */
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

    /**
     * Main is invoked if method is not specified.
     * Load the view of the login form, if there is no user identified.
     *
     * @return void
     */
    public function main()
    {
        if (!isset(Config::$username)) {
            Skin::setView(new LoginView($this));
        }
    }

    /**
     * Close the user session and go to the main page
     *
     * @return void
     */
    public function logout()
    {
        Config::$user->logout();
        header('Location: ' . BASE_URI);
    }
}
