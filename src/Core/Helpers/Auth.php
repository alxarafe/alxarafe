<?php
/**
 * Copyright (C) 2022-2023  Rafael San José Tovar   <info@rsanjoseo.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Alxarafe\Core\Helpers;

use Alxarafe\Core\Singletons\Debug;
use Alxarafe\Core\Singletons\DebugTool;
use Alxarafe\Database\Engine;
use Alxarafe\Controllers\Login;
use Alxarafe\Models\Users;
use DebugBar\DebugBarException;

/**
 * Class Auth
 *
 * @package Alxarafe\Helpers
 */
class Auth
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
    private static $user = null;

    private static $users;

    /**
     * Auth constructor.
     */
    public function __construct(string $index = 'main')
    {
        self::$users = new Users();
        self::getCookieUser();
    }

    /**
     * TODO: Undocummented
     */
    private static function getCookieUser()
    {
        if (self::$user === null) {
            if (isset($_COOKIE['user'])) {
                self::$user = $_COOKIE['user'];
            }
        }
    }

    /**
     * TODO: Undocummented
     * Esto no puede ser porque invoca a Login y carga el controlador.
     */
    public static function login()
    {
        //        dump(debug_backtrace());
        new Login();
    }

    /**
     * @throws DebugBarException
     */
    public static function logout()
    {
        Debug::addMessage('messages', 'Auth::Logout(): ' . (self::$user === null ? 'There was no identified user.' : 'User' . self::$user . ' has successfully logged out'));
        self::$user = null;
        self::clearCookieUser();
    }

    /**
     * TODO: Undocummented
     */
    private static function clearCookieUser()
    {
        setcookie('user', '');
        unset($_COOKIE['user']);
    }

    /**
     * TODO: Undocumented
     *
     * @return string|null
     */
    public static function getUser(): ?string
    {
        return self::$user;
    }

    /**
     * Try login for user and password.
     * Dolibarr uses serveral systems
     *
     * @param $user
     * @param $password
     *
     * @return bool
     * @throws DebugBarException
     * @see dol_hash in "htdocs/core/lib/security.lib.php"
     *
     */
    public static function setUser($user, $password): bool
    {
        $usernameField = 'username';
        $passwordField = 'password';
        $encryptMethod = "md5";

        $tablename = self::$users->tableName;
        $_user = Engine::select("SELECT * FROM {$tablename} WHERE $usernameField='$user';");
        if (count($_user) > 0 && password_verify($password, $_user[0][$passwordField])) {
            self::$user = $user;
            setcookie('user', $user);
            Debug::addMessage('messages', "$user autenticado");
        } else {
            self::$user = null;
            setcookie('user', '');
            unset($_COOKIE['user']);
            if (isset($_user[0])) {
                Debug::addMessage('messages', "Comprobado {$encryptMethod}:" . $encryptMethod($password, PASSWORD_DEFAULT) . ', en fichero: ' . $_user[0][$passwordField]);
            } else {
                Debug::addMessage('messages', "Comprobado {$encryptMethod}:" . $encryptMethod($password, PASSWORD_DEFAULT) . ', en fichero no existe usuario ' . $user);
            }
        }
        return self::$user != null;
    }
}
