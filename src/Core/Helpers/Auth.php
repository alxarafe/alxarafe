<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Helpers;

use Alxarafe\Models\Users;

class Auth extends Users
{

    public function logout()
    {
        Debug::addMessage('messages', 'Auth::Logout(): ' . (self::$user == null ? 'No había usuario identificado.' : 'El usuario ' . self::$user . ' ha cerrado la sesión'));
        Self::$user = null;
        setcookie('user', '');
        unset($_COOKIE['user']);
    }

    public function setUser($user, $password)
    {
        if (!database::tableExists($this->tablename)) {
            Self::$user = null;
            setcookie('user', '');
            unset($_COOKIE['user']);
            Debug::addMessage('SQL', "La tabla $tablename no existe");
            return;
        }
        //$user = Auth::$userTable->where('username', $user)->get()->toArray();
        //$_user = Auth::$userTable->where('username', $user)->get()->toArray();
        $_user = Config::$dbEngine->select("SELECT * FROM {$this->tablename} WHERE username='$user';");
        if (count($_user) > 0 && md5($password) == $_user[0]['password']) {
            Self::$user = $user;
            setcookie('user', $user);
            Debug::addMessage('SQL', "$user autenticado");
        } else {
            Self::$user = null;
            setcookie('user', '');
            unset($_COOKIE['user']);
            if (isset($_user[0])) {
                Debug::addMessage('SQL', "Comprobado md5:" . md5($password) . ', en fichero: ' . $_user[0]['password']);
            } else {
                Debug::addMessage('SQL', "Comprobado md5:" . md5($password) . ', en fichero no existe usuario ' . $user);
            }
        }
    }

    public static function getUser()
    {
        if (Self::$user == null) {
            if (isset($_COOKIE['user'])) {
                Self::$user = $_COOKIE['user'];
            }
        }
        return Self::$user;
    }
}
