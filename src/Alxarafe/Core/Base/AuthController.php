<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Base;

use Alxarafe\Core\Models\User;
use Alxarafe\Core\Providers\FlashMessages;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AuthController
 *
 * @package Alxarafe\Core\Base
 */
class AuthController extends Controller
{
    /**
     * Minimum cookie time expiration.
     */
    public const COOKIE_EXPIRATION_MIN = 3600;     // 1 hour

    /**
     * The user logged.
     *
     * @var User
     */
    public $user;

    /**
     * User log key.
     *
     * @var string|null
     */

    public $logkey = null;

    /**
     * Page to redirect.
     *
     * @var string
     */
    private $defaultRedirect = 'index.php?call=Login';

    /**
     * @param string $methodName
     *
     * @return Response
     */
    public function runMethod(string $methodName): Response
    {
        $method = $methodName . 'Method';
        $this->logger->addDebug($this->translator->trans('call-to', ['%called%' => $this->shortName . '->' . $method . '()']));
        if (!$this->checkAuth()) {
            $this->logger->addDebug($this->translator->trans('user-not-authenticated'));
            return $this->redirect(baseUrl($this->defaultRedirect));
        }
        return $this->{$method}();
    }

    /**
     * Check that user is logged in.
     */
    public function checkAuth(): bool
    {
        $this->user = new User();
        return $this->checkLoginWeb() || $this->checkLoginAPI();
    }

    /**
     * Check if user is logged-in from Login.
     *
     * @return bool
     */
    private function checkLoginWeb(): bool
    {
        $return = false;

        $username = $this->request->cookies->get('user', '');
        $logKey = $this->request->cookies->get('logkey', '');
        $remember = $this->request->cookies->get('remember', self::COOKIE_EXPIRATION_MIN);
        if (!empty($username) && !empty($logKey)) {
            if ($this->user->verifyLogKey($username, $logKey)) {
                $this->logger->addDebug($this->translator->trans('user-logged-in-from-cookie', ['%username%' => $username]));
                $this->username = $this->user->username;
                $this->logkey = $this->user->logkey;
                // Re-set cookie time to persist cookie time from last use
                $time = time() + $remember;
                $this->adjustCookieUser($time, $remember);
                $return = true;
            }
        }
        return $return;
    }

    /**
     * Check if user is logged-in from API.
     *
     * @return bool
     */
    private function checkLoginAPI(): bool
    {
        $return = false;

        $userAuth = $this->request->headers->get('PHP_AUTH_USER');
        $passAuth = $this->request->headers->get('PHP_AUTH_PW');
        if (!empty($userAuth) && !empty($passAuth)) {
            if ($this->user->getBy('username', $userAuth) && password_verify($passAuth, $this->user->password)) {
                $this->logger->addDebug($this->translator->trans('api-user-logged', ['%username%' => $userAuth]));
                $return = true;
            } else {
                $this->logger->addDebug($this->translator->trans('api-user-logged-fail', ['%username%' => $userAuth]));
            }
        }
        return $return;
    }

    /**
     * Adjust auth cookie user.
     *
     * @param int $time
     * @param int $remember
     */
    private function adjustCookieUser($time = 0, int $remember = 0): void
    {
        if ($time === 0) {
            $time = time() - 3600;
            $remember = null;
        }

        if (!$this->username) {
            $this->logkey = $this->user->generateLogKey($this->request->getClientIp() ?? '', false);
        }
        setcookie('user', $this->username, $time, constant('APP_URI'), $_SERVER['HTTP_HOST']);
        setcookie('logkey', $this->logkey, $time, constant('APP_URI'), $_SERVER['HTTP_HOST']);
        setcookie('remember', $remember, $time, constant('APP_URI'), $_SERVER['HTTP_HOST']);
    }

    /**
     * Close the user session and go to the main page
     *
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        FlashMessages::getInstance()::setInfo($this->translator->trans('user-logged-out'));
        $this->username = null;
        $this->logkey = null;
        $this->adjustCookieUser();
        return $this->redirect(baseUrl('index.php?call=Login'));
    }
}
