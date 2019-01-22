<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Helpers;

use Alxarafe\Controllers\Login;
use Alxarafe\Models\Users;

/**
 * Class Auth
 *
 * @package Alxarafe\Helpers
 */
class Auth extends Users
{

    /**
     * Cookie time expiration.
     */
    const COOKIE_EXPIRATION = 86400 * 30; // 30 days

    /**
     * User in use.
     *
     * @var string|null
     */
    private $user = null;

    /**
     * User log key.
     *
     * @var string|null
     */
    public $logkey = null;

    /**
     * Auth constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->getCookieUser();
    }

    /**
     * Returns the cookie from the user
     *
     * @return string|null
     */
    private function getCookieUser()
    {
        if ($this->user === null) {
            if (isset($_COOKIE['user']) && isset($_COOKIE['logkey']) && !$this->verifyLogKey($_COOKIE['user'], $_COOKIE['logkey'])) {
                $this->login();
            }
        } else {
            Debug::addMessage(
                'messages',
                'Auth::user yet setted (' . $_COOKIE['user'] . ', ' . $_COOKIE['logkey'] . '): '
            );
        }
        return $this->user;
    }

    /**
     * Login the user.
     */
    public function login()
    {
        new Login();
    }

    /**
     * Logout the user.
     */
    public function logout()
    {
        Debug::addMessage(
            'messages',
            'Auth::Logout(): ' . ($this->user === null ? 'There was no identified user.' : 'User' . $this->user . ' has successfully logged out')
        );

        $user = new Users();
        $user->getBy('username', $this->user);
        $user->logkey = null;
        $user->save();

        $this->user = null;

        $this->clearCookieUser();
    }

    /**
     * Clear the cookie user.
     */
    private function clearCookieUser()
    {
        setcookie('user', '', 0, constant('APP_URI'), $_SERVER['HTTP_HOST']);
        setcookie('logkey', '', 0, constant('APP_URI'), $_SERVER['HTTP_HOST']);
        unset($_COOKIE['user']);
        unset($_COOKIE['logkey']);
    }

    /**
     * Returns the user it setted or null.
     *
     * @return string|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * TODO: Undocumented
     *
     * @param string $userName
     * @param string $password
     *
     * @return bool
     */
    public function setUser($userName, $password): bool
    {
        $user = new Users();
        $user->getBy('username', $userName);

        if ($user !== false && password_verify($password, $user->password)) {
            $this->user = $user->username;
            $this->setCookieUser();
            Debug::addMessage('messages', "$userName authenticated");
        } else {
            $this->user = null;
            setcookie('user', '', 0, constant('APP_URI'), $_SERVER['HTTP_HOST']);
            setcookie('logkey', '', 0, constant('APP_URI'), $_SERVER['HTTP_HOST']);
            unset($_COOKIE['user']);
            unset($_COOKIE['logkey']);
            if ($user !== false) {
                if (password_verify($password, $user->password)) {
                    $msg = 'good password.';
                } else {
                    $msg = 'wrong password.';
                }
                Debug::addMessage('messages', "Checking hash " . $msg);
            } else {
                Debug::addMessage('messages', "User '" . $userName . "' not founded.");
            }
        }
        return $this->user !== null;
    }

    /**
     * Sets the cookie to the current user.
     */
    private function setCookieUser(): void
    {
        if ($this->user === null) {
            $this->clearCookieUser();
        } else {
            setcookie('user', $this->user, time() + self::COOKIE_EXPIRATION, constant('APP_URI'), $_SERVER['HTTP_HOST']);
            setcookie('logkey', $this->generateLogKey(), time() + self::COOKIE_EXPIRATION, constant('APP_URI'), $_SERVER['HTTP_HOST']);
        }
    }

    /**
     * Generate a log key.
     *
     * @param string $ip
     * @param bool   $unique
     *
     * @return string
     */
    public function generateLogKey(string $ip = '', bool $unique = true)
    {
        $logkey = '';
        if (!empty($_COOKIE['user'])) {
            $user = new Users();
            $user->getBy('username', $_COOKIE['user']);
            $text = $this->user;
            if ($unique) {
                $text .= '|' . $ip . '|' . date('Y-m-d H:i:s');
            }
            $text .= '|' . Utils::randomString();
            $logkey = password_hash($text, PASSWORD_DEFAULT);

            $user->logkey = $logkey;
            $user->save();
        }

        return $logkey;
    }

    /**
     * Verify is log key is correct.
     *
     * @param string $userName
     * @param string $hash
     *
     * @return bool
     */
    public function verifyLogKey(string $userName, string $hash)
    {
        $status = false;
        $user = new Users();
        $user->getBy('username', $userName);
        if ($user !== false && $hash === $user->logkey) {
            $this->user = $user->username;
            $this->logkey = $user->logkey;
            $status = true;
        }
        return $status;
    }
}
