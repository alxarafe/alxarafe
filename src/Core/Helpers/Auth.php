<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Helpers;

use Alxarafe\Models\Users;
use Alxarafe\Controllers\Login;

class Auth extends Users
{

    /**
     * TODO:
     */
    const COOKIE_EXPIRATION = 0;

    private $user = null;

    public function __construct()
    {
        parent::__construct();
        $this->getCookieUser();
    }

    private function getCookieUser()
    {
        if ($this->user == null) {
            if (isset($_COOKIE['user'])) {
                $this->user = $_COOKIE['user'];
            }
        }
    }

    private function setCookieUser()
    {
        setcookie('user', $this->user == null ? '' : $this->user, COOKIE_EXPIRATION);
    }

    private function clearCookieUser()
    {
        setcookie('user', '');
        unset($_COOKIE['user']);
    }

    public function login()
    {
        (new Login())->run();
    }

    public function logout()
    {
        Debug::addMessage('messages', 'Auth::Logout(): ' . ($this->user == null ? 'There was no identified user.' : 'User' . $this->user . ' has successfully logged out'));
        $this->user = null;
        $this->clearCookieUser();
    }

    public function setUser($user, $password)
    {
        $_user = Config::$dbEngine->select("SELECT * FROM {$this->tablename} WHERE username='$user';");
        if (count($_user) > 0 && md5($password) == $_user[0]['password']) {
            $this->user = $user;
            setcookie('user', $user);
            Debug::addMessage('SQL', "$user autenticado");
        } else {
            $this->user = null;
            setcookie('user', '');
            unset($_COOKIE['user']);
            if (isset($_user[0])) {
                Debug::addMessage('SQL', "Comprobado md5:" . md5($password) . ', en fichero: ' . $_user[0]['password']);
            } else {
                Debug::addMessage('SQL', "Comprobado md5:" . md5($password) . ', en fichero no existe usuario ' . $user);
            }
        }
        return $this->user != null;
    }

    public function getUser()
    {
        return $this->user;
    }
}
