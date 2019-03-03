<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Base;

use Alxarafe\Models\User;
use Alxarafe\Providers\FlashMessages;
use Alxarafe\Providers\Logger;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AuthController
 *
 * @package Alxarafe\Base
 */
class AuthController extends Controller
{
    /**
     * Minimum cookie time expiration.
     */
    const COOKIE_EXPIRATION_MIN = 3600;     // 1 hour

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
     * AuthController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param string $methodName
     *
     * @return Response
     */
    public function runMethod(string $methodName): Response
    {
        $method = $methodName . 'Method';
        Logger::getInstance()->getLogger()->addDebug($this->translator->trans('call-to', ['%called%' => $this->shortName . '->' . $method . '()']));
        if (!$this->checkAuth()) {
            Logger::getInstance()->getLogger()->addDebug($this->translator->trans('user-not-authenticated'));
            return $this->redirect(baseUrl($this->defaultRedirect));
        }
        return $this->{$method}();
    }

    /**
     * Check that user is logged in.
     */
    public function checkAuth(): bool
    {
        $return = false;
        $Auth = $this->request->headers->get('Authorization');
        $username = $this->request->cookies->get('user', '');
        $logKey = $this->request->cookies->get('logkey', '');
        $remember = $this->request->cookies->get('remember', self::COOKIE_EXPIRATION_MIN);

        if (!empty($username) && !empty($logKey)) {
            $user = new User();
            if ($user->verifyLogKey($username, $logKey)) {
                Logger::getInstance()->getLogger()->addDebug($this->translator->trans('user-logged-in-from-cookie', ['%username%' => $username]));
                $this->user = $user;
                $this->username = $this->user->username;
                $this->logkey = $this->user->logkey;
                // Re-set cookie time to persist cookie time from last use
                $time = time() + $remember;
                $this->adjustCookieUser($time, $remember);
                $return = true;
            }
        } elseif (!is_null($Auth)) {
            Logger::getInstance()->getLogger()->addDebug($this->translator->trans('auth-is-null'));
            // TODO: Check with Auth header if has valid credentials
            $return = true;
        }
        return $return;
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
        $this->user = null;
        $this->logkey = null;
        $this->adjustCookieUser();
        return $this->redirect(baseUrl('index.php?call=Login'));
    }

    /**
     * Adjust auth cookie user.
     *
     * @param int $time
     * @param int $remember
     */
    private function adjustCookieUser($time = 0, int $remember = 0): void
    {
        if ($time == 0) {
            $time = time() - 3600;
            $remember = null;
        }

        if ($this->user) {
            $this->logkey = $this->user->generateLogKey($this->request->getClientIp() ?? '', true);
        }
        setcookie('user', $this->username, $time, constant('APP_URI'), $_SERVER['HTTP_HOST']);
        setcookie('logkey', $this->logkey, $time, constant('APP_URI'), $_SERVER['HTTP_HOST']);
        setcookie('remember', $remember, $time, constant('APP_URI'), $_SERVER['HTTP_HOST']);
    }
}
