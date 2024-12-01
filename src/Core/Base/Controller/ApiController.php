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
use Alxarafe\Lib\Auth;
use Alxarafe\Lib\Messages;
use Alxarafe\Lib\Trans;
use CoreModules\Admin\Model\User;
use DebugBar\DebugBarException;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

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
     * ApiController constructor.
     * @throws DebugBarException
     */
    public function __construct()
    {
        $config = Config::getConfig();
        if (!isset($config->db) || !static::connectDb($config->db)) {
            header('Location: ' . constant('BASE_URL') . '/index.php?module=Admin&controller=Config');
            die();
        }

        if (isset($_REQUEST['token'])) {
            static::checkToken();
        }
    }

    /**
     * Verifies the received token and loads the user associated with it.
     *
     * @return bool
     */
    public static function checkToken(): bool
    {
        $jwt = $_REQUEST['token'];
        $secret_key = Auth::getSecurityKey();
        try {
            $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));
        } catch (Exception $e) {
            self::badApiCall(Trans::_('bad_secret_key'), 401);
            return false;
        }

        static::$user = User::where('name', $decoded->data->user)->first();
        return static::$user !== null;
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
        $result = [
            'ok' => false,
            'status' => $httpCode,
            'response' => $response,
            'message' => Messages::getMessages(),
        ];

        http_response_code($httpCode);
        header('Content-Type: application/json');
        die(json_encode(static::debugEnabled($result)));
    }

    /**
     * Return true if debug is enabled in config
     *
     * @return array
     */
    private static function debugEnabled($info): array
    {
        $config = Config::getConfig();
        $debug = $config->security->debug ?? false;

        if (!$debug) {
            return $info;
        }

        return array_merge($info, [
            'debug' => debug_backtrace(),
        ]);
    }

    /**
     * Returns a successful API response and ends the execution of the application.
     *
     * @param $response
     * @param $httpCode
     * @return void
     */
    final public static function jsonResponse($response, $httpCode = 200, $result_message = 'result')
    {
        $result = [
            'ok' => true,
            'status' => $httpCode,
            $result_message => $response,
            'message' => Messages::getMessages(),
        ];

        http_response_code($httpCode);
        header('Content-Type: application/json');
        die(json_encode(static::debugEnabled($result)));
    }
}
