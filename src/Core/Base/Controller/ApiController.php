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
use CoreModules\Admin\Model\User;
use Firebase\JWT\JWT;
use Luracast\Restler\RestException;

/**
 * Class ApiController. The generic API controller contains what is necessary for any API controller
 *
 * @package Alxarafe\Base
 */
abstract class ApiController
{
    private static $security_key=null;

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

    public static function badApiCall()
    {

    }

    public static function jsonResponse($response, $httpCode = 200) {

    }
}
