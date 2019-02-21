<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Controllers;

use Alxarafe\Base\PageController;
use Alxarafe\Helpers\Auth;
use Alxarafe\Providers\FlashMessages;

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
     * The start point of the controller.
     *
     * @return void
     */
    public function run(): void
    {
        $this->index();
    }

    /**
     * Start point
     *
     * @return void
     */
    public function index(): void
    {
        $this->redirect = filter_input(INPUT_GET, 'redirect', FILTER_SANITIZE_ENCODED);
        $this->userAuth = new Auth();

        if (isset($_COOKIE ['user']) && isset($_COOKIE ['logkey'])) {
            $this->userName = $this->userAuth->getCookieUser();
        } elseif (filter_input(INPUT_POST, 'login', FILTER_SANITIZE_ENCODED) === 'true') {
            $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_ENCODED);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_ENCODED);
            $remember = filter_input(INPUT_POST, 'remember-me', FILTER_SANITIZE_ENCODED);
            $remember = isset($remember);
            if ($this->userAuth->setUser($username, $password, $remember)) {
                FlashMessages::getInstance()::setSuccess("User '" . $username . "' logged in.");
                $this->redirectToController();
            } else {
                FlashMessages::getInstance()::setError('User authentication error. Please check the username and password.');
            }
        }
        $this->main();
        $this->sendTemplateResponse();
    }

    /**
     * Redirect to controller, default or selected by the user.
     */
    private function redirectToController(): void
    {
        $where = constant('BASE_URI') . '/index.php?' . constant('CALL_CONTROLLER') . '=' . constant('DEFAULT_CONTROLLER');
        if (!empty($this->redirect)) {
            $where = base64_decode(urldecode($this->redirect));
        }
        $this->debugTool->addMessage('messages', $where);
        redirect($where);
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
            $this->renderer->setTemplate('login');
            $this->sendTemplateResponse();
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
        $this->userAuth->logout();
    }

    /**
     * Returns the page details.
     *
     * @return array
     */
    public function pageDetails(): array
    {
        $details = [
            'title' => 'user-authentication',
            'icon' => '<span class="glyphicon glyphicon-user" aria-hidden="true"></span>',
            'description' => 'user-authentication-description',
            'menu' => '',
        ];
        return $details;
    }
}
