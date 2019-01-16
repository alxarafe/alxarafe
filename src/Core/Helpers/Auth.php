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
     * TODO: Undocumented
     */
    const COOKIE_EXPIRATION = 0;

    /**
     * TODO: Undocumented
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
     * TODO: Undocummented
     */
    private function getCookieUser()
    {
        if ($this->user === null) {
            if (isset($_COOKIE['user'])) {
                $this->user = $_COOKIE['user'];
            }
        }
    }

    /**
     * TODO: Undocummented
     */
    public function login()
    {
        new Login();
    }

    /**
     * TODO: Undocumented
     */
    public function logout()
    {
        Debug::addMessage('messages', 'Auth::Logout(): ' . ($this->user === null ? 'There was no identified user.' : 'User' . $this->user . ' has successfully logged out'));
        $this->user = null;
        $this->clearCookieUser();
    }

    /**
     * TODO: Undocummented
     */
    private function clearCookieUser()
    {
        setcookie('user', '');
        unset($_COOKIE['user']);
    }

    /**
     * TODO: Undocumented
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
        if (count($_user) > 0 && md5($password) == $_user[0]['password']) {
            $this->user = $user;
            setcookie('user', $user);
            Debug::addMessage('SQL', "$user autenticado");
        } else {
            $this->user = null;
            setcookie('user', '');
            unset($_COOKIE['user']);
            if (isset($_user[0])) {
                if (password_verify($password, $_user[0]['password'])) {
                    $msg = 'contraseña correcta.';
                } else {
                    $msg = 'contraseña incorrecta.';
                }
                Debug::addMessage('SQL', "Comprobado hash " . $msg);
            } else {
                Debug::addMessage('SQL', 'Comprobado hash, en fichero no existe usuario ' . $user);
            }
        }
        return $this->user !== null;
    }

    /**
     * TODO: Undocummented
     */
    private function setCookieUser(): void
    {
        setcookie('user', $this->user === null ? '' : $this->user, self::COOKIE_EXPIRATION);
    }
}
