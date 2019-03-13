<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Controllers;

use Alxarafe\Core\Base\Controller;
use Alxarafe\Core\Models\User;
use Alxarafe\Core\Providers\FlashMessages;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class Login
 *
 * @package Alxarafe\Core\Controllers
 */
class Login extends Controller
{
    /**
     * Cookie time expiration.
     */
    public const COOKIE_EXPIRATION = 2592000;       // 30 days

    /**
     * Minimum cookie time expiration.
     */
    public const COOKIE_EXPIRATION_MIN = 3600;     // 1 hour

    /**
     * Where to redirect if needed.
     *
     * @var string|null
     */
    public $redirectUrl;

    /**
     * User log key.
     *
     * @var string|null
     */
    public $logkey = null;

    /**
     * User in use.
     *
     * @var User|null
     */
    private $user = null;

    /**
     * Returns the page details.
     *
     * @return array
     */
    public function pageDetails(): array
    {
        $details = [
            'title' => 'user-authentication',
            'icon' => '<i class="fas fa-user"></i>',
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
        $this->redirectUrl = $this->request->query->get('redirectUrl');
        $user = $this->request->cookies->get('user', '');
        $logKey = $this->request->cookies->get('logkey', '');

        $remember = $this->request->request->get('remember-me');
        $remember = isset($remember);
        switch ($this->request->request->get('action')) {
            case 'login':
                $username = $this->request->request->get('username');
                $password = $this->request->request->get('password');
                if ($this->setUser($username, $password, $remember)) {
                    FlashMessages::getInstance()::setSuccess($this->translator->trans('user-logged-in', ['%username%' => $username]));
                    return $this->redirectToController();
                }
                FlashMessages::getInstance()::setError($this->translator->trans('user-authentication-error'));
                break;
            default:
                if ($user && $logKey) {
                    $this->username = $this->getCookieUser($remember);
                    if ($this->username === null) {
                        $request = $this->request->server->get('REQUEST_URI');
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
        return $this->redirect($where);
    }

    /**
     * Returns the cookie from the user
     *
     * @param $remember
     *
     * @return string|null
     */
    public function getCookieUser($remember): ?string
    {
        $this->user = new User();
        $user = $this->request->cookies->get('user', '');
        $logKey = $this->request->cookies->get('logkey', '');
        if ($this->username === null && $this->user->getBy('username', $user) === true) {
            if ($this->user->verifyLogKey($user, $logKey)) {
                $this->logger->addDebug($this->translator->trans('user-logged-in-from-cookie', ['%username%' => $user]));
                // Increase cookie valid time.
                $time = time() + ($remember ? self::COOKIE_EXPIRATION : self::COOKIE_EXPIRATION_MIN);
                $this->adjustCookieUser($time, $remember);
            } else {
                $this->logger->addDebug($this->translator->trans('user-authentication-error'));
                $this->clearCookieUser();
            }
        }
        return $this->username;
    }

    /**
     * Adjust auth cookie user.
     *
     * @param int $time
     * @param int $remember
     */
    private function adjustCookieUser(int $time = 0, int $remember = 0): void
    {
        if ($time === 0) {
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

    /**
     * Clear the cookie user.
     *
     * @return void
     */
    private function clearCookieUser(): void
    {
        $this->logger->addDebug($this->translator->trans('user-cookies-cleared'));
        $this->username = null;
        $this->user = null;
        $this->logkey = null;
        $this->adjustCookieUser();
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
        }
        return $this->redirectToController();
    }

    /**
     * Close the user session and go to the main page
     *
     * @return RedirectResponse
     */
    public function logoutMethod(): RedirectResponse
    {
        FlashMessages::getInstance()::setInfo($this->translator->trans('user-logged-out'));
        $this->clearCookieUser();
        return $this->redirect(baseUrl('index.php?call=Login'));
    }

    /**
     * Returns the user name if setted or null.
     *
     * @return string|null
     */
    public function getUserName(): ?string
    {
        return $this->username;
    }

    /**
     * Returns the user if setted or null.
     *
     * @return User|null
     */
    public function getUser(): ?User
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
                $this->adjustCookieUser($time, ($remember ? self::COOKIE_EXPIRATION : self::COOKIE_EXPIRATION_MIN));
                $this->logger->addDebug($this->translator->trans('user-authenticated', ['%username%' => $this->user->username]));
            } else {
                $this->clearCookieUser();
                $this->logger->addDebug($this->translator->trans('user-authentication-wrong-password'));
            }
        } else {
            $this->logger->addDebug($this->translator->trans('user-authentication-not-found', ['%username%' => $userName]));
        }
        return $this->username !== null;
    }
}
