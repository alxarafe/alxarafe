<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Controllers;

use Alxarafe\Base\PageController;
use Alxarafe\Helpers\Auth;
use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Skin;
use Alxarafe\Views\LoginView;

/**
 * Class Login
 *
 * @package Alxarafe\Controllers
 */
class Login extends PageController
{

    /**
     * Login constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Start point
     */
    public function run()
    {
        if (filter_input(INPUT_POST, 'login', FILTER_SANITIZE_ENCODED) === 'true') {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_ENCODED);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_ENCODED);
            $this->userAuth = new Auth();
            if ($this->userAuth->setUser($username, $password)) {
                // TODO: If user is trying to go to another place, go to it.
                header('Location: ' . constant('BASE_URI') . '/index.php?call=' . constant(DEFAULT_CONTROLLER));
            }
            Config::setError('User authentication error. Please check the username and password.');
        }
        $this->main();
        //parent::run();
    }

    /**
     * Main is invoked if method is not specified.
     * Load the view of the login form, if there is no user identified.
     *
     * @return void
     */
    public function main(): void
    {
        if (!isset($this->userName)) {
            Skin::setView(new LoginView($this));
            //header('Location: ' . constant('BASE_URI') . '/index.php?call=Login');
        }
    }

    /**
     * Close the user session and go to the main page
     *
     * @return void
     */
    public function logout(): void
    {
        if ($this->userAuth) {
            $this->userAuth->logout();
        }
        header('Location: ' . constant('BASE_URI'));
    }

    /**.
     * Returns the page details.
     */
    public function pageDetails()
    {
        $details = [
            'title' => 'Identificación de usuario',
            'icon' => '<span class="glyphicon glyphicon-user" aria-hidden="true"></span>',
            'description' => 'Página de login, para controlar el acceso a la aplicación.',
            'menu' => [],
        ];
        return $details;
    }
}
