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
    const COOKIE_EXPIRATION = 86400*30; // 30 days

    /**
     * User in use.
     *
     * @var string|null
     */
    private $user = null;

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
            if (isset($_COOKIE['user'])) {
                $this->user = $_COOKIE['user'];
            }
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
        $this->user = null;
        $this->clearCookieUser();
    }

    /**
     * Clear the cookie user.
     */
    private function clearCookieUser()
    {
        setcookie('user', '');
        unset($_COOKIE['user']);
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
     * @param string $user
     * @param string $password
     *
     * @return bool
     */
    public function setUser($user, $password): bool
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE username='$user';";
        $_user = Config::$dbEngine->select($sql);
        if (count($_user) > 0 && password_verify($password, $_user[0]['password'])) {
            $this->user = $user;
            $this->setCookieUser();
            Debug::addMessage('messages', "$user authenticated");
        } else {
            $this->user = null;
            setcookie('user', '');
            unset($_COOKIE['user']);
            if (isset($_user[0])) {
                if (password_verify($password, $_user[0]['password'])) {
                    $msg = 'good password.';
                } else {
                    $msg = 'wrong password.';
                }
                Debug::addMessage('messages', "Checking hash " . $msg);
            } else {
                Debug::addMessage('messages', "User '" . $user . "' not founded.");
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
            setcookie('user', $this->user, time() + self::COOKIE_EXPIRATION);
        }
    }
}
