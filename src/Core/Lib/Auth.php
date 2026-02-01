<?php

/* Copyright (C) 2024      Rafael San José      <rsanjose@alxarafe.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Alxarafe\Lib;

use Alxarafe\Base\Config;
use CoreModules\Admin\Controller\ConfigController;
use CoreModules\Admin\Model\User;
use DebugBar\DebugBarException;
use Random\RandomException;

abstract class Auth
{
    private const COOKIE_NAME = 'alxarafe_login';
    private const COOKIE_USER = self::COOKIE_NAME . '_user';
    private const COOKIE_EXPIRE_TIME = 30 * 24 * 60 * 60; // 30 days
    private const COOKIE_SAMESITE = 'Strict';

    public static ?User $user = null;
    /**
     * Contains the JWT security key
     *
     * @var string|null
     */
    private static ?string $security_key = null;

    public static function isLogged(): bool
    {
        $userId = FILTER_INPUT(INPUT_COOKIE, self::COOKIE_USER);
        $token = FILTER_INPUT(INPUT_COOKIE, self::COOKIE_NAME);

        if (empty($token)) {
            return false;
        }

        try {
            /** @var User|null $user */
            $user = User::find($userId);
            self::$user = $user;
        } catch (\Exception $e) {
            Messages::addError(Trans::_('error_message', ['message' => $e->getMessage()]));
            Functions::httpRedirect(ConfigController::url());
        }

        return self::$user->token === $token;
    }

    /**
     * Return true if login is correct with user/mail and password.
     * TODO: This is a test. It will be checked against a user database.
     *
     * @param string $username
     * @param string $password
     *
     * @return bool
     */
    public static function login(string $username, string $password): bool
    {
        $user = User::where('name', $username)->first();

        if (!isset($user)) {
            return false;
        }

        if (!password_verify($password, $user->password)) {
            return false;
        }

        self::setLoginCookie($user->id);

        return true;
    }

    public static function setLoginCookie($userId): void
    {
        /** @var User|null $user */
        $user = User::find($userId);
        self::$user = $user;

        $token = self::generateToken();

        if (isset(self::$user)) {
            self::$user->saveToken($token);
        }

        /**
         * Ideally, "secure" is set to true, but this does not work with self-signed certificates.
         * With "secure" set to false, it is important that samesite is set to Strict.
         */
        $cookie_options = [
            'expires' => time() + self::COOKIE_EXPIRE_TIME,
            'path' => '/',
            'domain' => $_SERVER['HTTP_HOST'],
            'secure' => false,
            'httponly' => true,
            'samesite' => self::COOKIE_SAMESITE,
        ];

        setcookie(self::COOKIE_USER, $userId);
        setcookie(self::COOKIE_NAME, $token, $cookie_options);
    }

    private static function generateToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    public static function logout(): void
    {
        // Erase old cookies.
        setcookie(self::COOKIE_USER, '', time() - 60);
        setcookie(self::COOKIE_NAME, '', time() - 60);
    }

    /**
     * Return the JWT security Key
     *
     * @return string|null
     * @throws DebugBarException
     * @throws RandomException
     */
    public static function getSecurityKey()
    {
        if (self::$security_key !== null) {
            return self::$security_key;
        }

        $config = Config::getConfig();
        if (!isset($config->security->jwt_secret_key)) {
            $config->security->jwt_secret_key = bin2hex(random_bytes(20));
            if (!Config::setConfig($config)) {
                return null;
            }
        }

        self::$security_key = $config->security->jwt_secret_key;
        return self::$security_key;
    }
}
