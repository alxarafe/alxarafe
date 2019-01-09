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
    private function setCookieUser()
    {
        setcookie('user', $this->user === null ? '' : $this->user, self::COOKIE_EXPIRATION);
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
     * TODO: Undocummented
     */
    public function login()
    {
        new Login();
        /*
          var_dump($this);
          var_dump(skin::$view);
          skin::$view = new \Alxarafe\Views\LoginView($this);
          // header('Location: ' . BASE_URI . '?call=Login');
          die;
         * 
         */
    }

    /**
     * @throws \DebugBar\DebugBarException
     */
    public function logout()
    {
        Debug::addMessage('messages', 'Auth::Logout(): ' . ($this->user === null ? 'There was no identified user.' : 'User' . $this->user . ' has successfully logged out'));
        $this->user = null;
        $this->clearCookieUser();
    }

    /**
     * TODO: Undocumented
     *
     * @param $user
     * @param $password
     *
     * @return bool
     * @throws \DebugBar\DebugBarException
     */
    public function setUser($user, $password)
    {
        $_user = Config::$dbEngine->select("SELECT * FROM {$this->tableName} WHERE username='$user';");
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

    /**
     * TODO: Undocumented
     *
     * @return string|null
     */
    public function getUser()
    {
        return $this->user;
    }
}
