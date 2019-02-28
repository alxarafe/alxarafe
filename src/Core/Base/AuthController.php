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
        $username = $this->request->cookies->get('user');
        $logkey = $this->request->cookies->get('logkey');

        if (!empty($username) && !empty($logkey)) {
            $user = new User();
            if ($user->verifyLogKey($username, $logkey)) {
                $this->user = $user;
                $this->username = $this->user->username;
                $this->logkey = $this->user->logkey;
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
}
