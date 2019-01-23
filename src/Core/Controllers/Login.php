<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Controllers;

use Alxarafe\Base\PageController;
use Alxarafe\Helpers\Auth;
use Alxarafe\Helpers\Config;
use Alxarafe\Helpers\Debug;
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
     * Where to redirect if needed.
     *
     * @var string|null
     */
    public $redirect;

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
    public function index()
    {
        $this->redirect = filter_input(INPUT_GET, 'redirect', FILTER_SANITIZE_ENCODED);

        if (isset($_COOKIE ['user']) && isset($_COOKIE ['logkey'])) {
            $this->userAuth = new Auth();
            $this->userName = $this->userAuth->getCookieUser();
        } elseif (filter_input(INPUT_POST, 'login', FILTER_SANITIZE_ENCODED) === 'true') {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_ENCODED);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_ENCODED);
            $this->userAuth = new Auth();
            if ($this->userAuth->setUser($username, $password)) {
                $this->redirectToController();
            }
            Config::setError('User authentication error. Please check the username and password.');
        }
        $this->main();
        //parent::run();
    }

    /**
     * Redirect to controller, default or selected by the user.
     */
    private function redirectToController(): void
    {
        $where = constant('BASE_URI') . '/index.php?call=' . constant('DEFAULT_CONTROLLER');
        if (!empty($this->redirect)) {
            $where = urldecode(base64_decode($this->redirect));
        }
        Debug::addMessage('messages', $where);
        header('Location: ' . $where);
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
        } else {
            $this->redirectToController();
        }
    }

    /**
     * Close the user session and go to the main page
     *
     * @return void
     */
    public function logout(): void
    {
        $this->run();
        $this->userAuth->logout();
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
            'menu' => '',
        ];
        return $details;
    }
}
