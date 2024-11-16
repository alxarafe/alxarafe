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

namespace Alxarafe\Base\Controller;

use Alxarafe\Base\Config;
use Alxarafe\Base\Controller\Trait\DbTrait;
use Alxarafe\Base\Database;
use CoreModules\Admin\Model\User;
use Psr\Container\ContainerInterface;

/**
 * Class ApiController. The generic API controller contains what is necessary for any API controller
 *
 * @package Alxarafe\Base
 */
abstract class ApiController
{
    use DbTrait;

    /**
     * Contains the identified user
     *
     * @var User|null
     */
    public static ?User $user = null;
    /**
     * Contains the JWT security key
     *
     * @var string|null
     */
    private static ?string $security_key = null;

    public function __construct()
    {
        $config = Config::getConfig();
        if (!isset($config->db) || !static::connectDb($config->db)) {
            header('Location: ' . constant('BASE_URL') . '/index.php?module=Admin&controller=Config');
        }

        $this->db = new Database($config->db);
    }

    /**
     * Returns a successful API response and ends the execution of the application.
     *
     * @param $response
     * @param $httpCode
     * @return void
     */
    final public static function jsonResponse($response, $httpCode = 200)
    {
        http_response_code($httpCode);
        header('Content-Type: application/json');
        die(json_encode($response));
    }

    /**
     * Return the JWT security Key
     *
     * @return string|null
     * @throws \DebugBar\DebugBarException
     * @throws \Random\RandomException
     */
    protected static function getSecurityKey()
    {
        if (self::$security_key !== null) {
            return self::$security_key;
        }

        $config = Config::getConfig();
        if (!isset($config->security->jwt_secret_key)) {
            $config->security->jwt_secret_key = bin2hex(random_bytes(20));
            if (!Config::setConfig($config)) {
                static::badApiCall();
            }
        }

        self::$security_key = $config->security->jwt_secret_key;
        return self::$security_key;
    }

    /**
     * Returns an erroneous API response and ends the execution of the call
     *
     * @param $response
     * @param $httpCode
     * @return void
     */
    final public static function badApiCall($response = 'Bad API call', $httpCode = 400)
    {
        http_response_code($httpCode);
        header('Content-Type: application/json');
        die(json_encode($response));
    }
}
