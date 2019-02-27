<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Controllers;

use Alxarafe\Base\Controller;
use Alxarafe\Models\User;
use Alxarafe\Providers\FlashMessages;
use Alxarafe\Providers\Logger;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Login
 *
 * @package Alxarafe\Controllers
 */
class Login extends Controller
{
    /**
     * Cookie time expiration.
     */
    const COOKIE_EXPIRATION = 86400 * 30;   // 30 days

    /**
     * Minimum cookie time expiration.
     */
    const COOKIE_EXPIRATION_MIN = 3600;     // 1 hour

    /**
     * Where to redirect if needed.
     *
     * @var string|null
     */
    public $redirectUrl;

    /**
     * User in use.
     *
     * @var User|null
     */
    private $user = null;

    /**
     * User log key.
     *
     * @var string|null
     */

    public $logkey = null;

    /**
     * Login constructor.
     */
    public function __construct()
    {
        parent::__construct();
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

    /**
     * The start point of the controller.
     *
     * @return Response
     */
    public function indexMethod(): Response
    {
        $this->redirectUrl = filter_input(INPUT_GET, 'redirectUrl', FILTER_SANITIZE_ENCODED);
        $user = $this->request->cookies->get('user');
        $logkey = $this->request->cookies->get('logkey');

        $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);
        $remember = filter_input(INPUT_POST, 'remember-me', FILTER_SANITIZE_STRING);
        $remember = isset($remember);
        switch ($action) {
            case 'login':
                $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
                $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
                if ($this->setUser($username, $password, $remember)) {
                    FlashMessages::getInstance()::setSuccess("User '" . $username . "' logged in.");
                    return $this->redirectToController();
                } else {
                    FlashMessages::getInstance()::setError('User authentication error. Please check the username and password.');
                }
                break;
            default:
                if ($user && $logkey) {
                    $this->username = $this->getCookieUser($remember);
                    if (is_null($this->username)) {
                        $request = filter_input(INPUT_SERVER, 'REQUEST_URI');
                        if (strpos($request, constant('CALL_CONTROLLER') . '=Login') === false) {
                            $redirectTo = '&redirect=' . \urlencode(base64_encode($request));
                            $url = baseUrl('index.php?' . constant('CALL_CONTROLLER') . '=Login' . $redirectTo);
                            return $this->redirect($url);
                        }
                    }
                }
                break;
        }
        return $this->main();
    }

    /**
     * Close the user session and go to the main page
     *
     * @return RedirectResponse
     */
    public function logoutMethod(): RedirectResponse
    {
        FlashMessages::getInstance()::setInfo('Logout: User has successfully logged out');
        $this->clearCookieUser();
        return $this->redirect(baseUrl('index.php?call=Login'));
    }

    /**
     * Redirect to controller, default or selected by the user.
     *
     * @return RedirectResponse
     */
    private function redirectToController(): RedirectResponse
    {
        $where = baseUrl('index.php?' . constant('CALL_CONTROLLER') . '=' . constant('DEFAULT_CONTROLLER'));
        if (!empty($this->redirectUrl)) {
            $where = base64_decode(urldecode($this->redirectUrl));
        }
        $this->debugTool->addMessage('messages', $where);
        return $this->redirect($where);
    }

    /**
     * Main is invoked if method is not specified.
     * Load the view of the login form, if there is no user identified.
     *
     * @return Response
     */
    private function main(): Response
    {
        if (!isset($this->username)) {
            $this->renderer->setTemplate('login');
            return $this->sendResponseTemplate();
        } else {
            return $this->redirectToController();
        }
    }

    /**
     * Clear the cookie user.
     *
     * @return void
     */
    private function clearCookieUser(): void
    {
        Logger::getInstance()->getLogger()->addDebug('Clear user cookies.');
        $this->username = null;
        $this->user = null;
        $this->logkey = null;
        $this->adjustCookieUser();
    }

    /**
     * Adjust auth cookie user.
     *
     * @param int $time
     *
     * @return void
     */
    private function adjustCookieUser($time = 0): void
    {
        if ($time == 0) {
            $time = time() - 3600;
        }

        if ($this->user) {
            $this->logkey = $this->user->generateLogKey($this->request->getClientIp() ?? '', true);
        }
        setcookie('user', $this->username, $time, constant('APP_URI'), $_SERVER['HTTP_HOST']);
        setcookie('logkey', $this->logkey, $time, constant('APP_URI'), $_SERVER['HTTP_HOST']);
    }

    /**
     * Returns the user name if setted or null.
     *
     * @return string|null
     */
    public function getUserName()
    {
        return $this->username;
    }

    /**
     * Returns the user if setted or null.
     *
     * @return User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set cookie's user.
     *
     * @param string $userName
     * @param string $password
     * @param bool   $remember
     *
     * @return bool
     */
    public function setUser($userName, $password, $remember = false): bool
    {
        $this->user = new User();
        $this->username = null;

        if ($this->user->getBy('username', $userName) === true) {
            if ($this->user->verifyPassword($password)) {
                $this->username = $this->user->username;
                $time = time() + ($remember ? self::COOKIE_EXPIRATION : self::COOKIE_EXPIRATION_MIN);
                $this->adjustCookieUser($time);
                Logger::getInstance()->getLogger()->addDebug($this->user->username . " authenticated");
            } else {
                $this->clearCookieUser();
                Logger::getInstance()->getLogger()->addDebug("Checking hash wrong password");
            }
        } else {
            Logger::getInstance()->getLogger()->addDebug("User '" . $userName . "' not founded.");
        }
        return $this->username !== null;
    }

    /**
     * Returns the cookie from the user
     *
     * @return string|null
     */
    public function getCookieUser($remember)
    {
        $this->user = new User();
        if ($this->username === null && $this->user->getBy('username', $_COOKIE['user']) === true) {
            if (isset($_COOKIE['user']) && isset($_COOKIE['logkey']) && $this->user->verifyLogKey($_COOKIE['user'], $_COOKIE['logkey'])) {
                Logger::getInstance()->getLogger()->addDebug('Login from cookie.');
                // Increase cookie valid time.
                $time = time() + ($remember ? self::COOKIE_EXPIRATION : self::COOKIE_EXPIRATION_MIN);
                $this->adjustCookieUser($time);
            } else {
                $this->clearCookieUser();
            }
        }
        return $this->username;
    }
}
