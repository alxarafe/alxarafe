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
    private $username = null;

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
    public function getCookieUser()
    {
        if ($this->username === null) {
            if (isset($_COOKIE['user']) && isset($_COOKIE['logkey']) && !$this->verifyLogKey($_COOKIE['user'], $_COOKIE['logkey'])) {
                $this->login();
            }
        } else {
            Debug::addMessage(
                'messages',
                'Auth::user yet setted (' . $_COOKIE['user'] . ', ' . $_COOKIE['logkey'] . '): '
            );
        }
        return $this->username;
    }

    /**
     * Login the user.
     */
    public function login()
    {
        $redirectTo = '&redirect=' . urlencode(base64_encode($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']));
        header('Location: ' . constant('BASE_URI') . '/index.php?call=Login' . $redirectTo);
    }

    /**
     * Logout the user.
     */
    public function logout()
    {
        Debug::addMessage(
            'messages',
            'Auth::Logout(): ' . ($this->username === null ? 'There was no identified user.' : 'User' . $this->username . ' has successfully logged out')
        );

        $user = new Users();
        $user->getBy('username', $this->username);
        $user->logkey = null;
        $user->save();

        $this->username = null;

        $this->clearCookieUser();
        header('Location: ' . constant('BASE_URI') . '/index.php');
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
     * Returns the user name if setted or null.
     *
     * @return string|null
     */
    public function getUserName()
    {
        return $this->username;
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
            $this->username = $user->username;
            $this->setCookieUser();
            Debug::addMessage('messages', "$userName authenticated");
        } else {
            $this->username = null;
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
        return $this->username !== null;
    }

    /**
     * Sets the cookie to the current user.
     */
    private function setCookieUser(): void
    {
        if ($this->username === null) {
            $this->clearCookieUser();
        } else {
            setcookie('user', $this->username, time() + self::COOKIE_EXPIRATION, constant('APP_URI'), $_SERVER['HTTP_HOST']);
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
            $text = $this->username;
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
            $this->username = $user->username;
            $this->logkey = $user->logkey;
            $status = true;
        }
        return $status;
    }
}
