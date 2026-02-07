<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

declare(strict_types=1);

namespace Alxarafe\Base\Controller;

use Alxarafe\Base\Config;
use Alxarafe\Base\Controller\Trait\DbTrait;
use Alxarafe\Lib\Auth;
use Alxarafe\Lib\Functions;
use Alxarafe\Lib\Messages;
use Alxarafe\Lib\Trans;
use CoreModules\Admin\Controller\ConfigController;
use CoreModules\Admin\Model\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * Class ApiController.
 *
 * Base controller for API endpoints, handling JWT authentication
 * and JSON responses.
 *
 * @package Alxarafe\Base
 */
abstract class ApiController
{
    use DbTrait;

    /**
     * Identified user via JWT token.
     */
    public static ?User $user = null;

    /**
     * ApiController constructor.
     */
    public function __construct()
    {
        $config = Config::getConfig();

        // Ensure database connection
        if (!isset($config->db) || !static::connectDb($config->db)) {
            Functions::httpRedirect(ConfigController::url());
        }

        // Check for token in request
        if (isset($_REQUEST['token'])) {
            static::checkToken();
        }
    }

    /**
     * Verifies the received JWT token and loads the associated user.
     */
    public static function checkToken(): bool
    {
        $jwt = (string) ($_REQUEST['token'] ?? '');
        $secretKey = Auth::getSecurityKey();

        try {
            $decoded = JWT::decode($jwt, new Key($secretKey, 'HS256'));

            // Simplified user lookup using nullsafe operator or direct check
            static::$user = User::where('name', $decoded->data->user)->first();

            return static::$user !== null;
        } catch (Exception) {
            self::badApiCall(Trans::_('bad_secret_key'), 401);
        }
    }

    /**
     * Terminates execution with a JSON error response.
     */
    final public static function badApiCall(mixed $response = 'Bad API call', int $httpCode = 400): never
    {
        $result = [
            'ok' => false,
            'status' => $httpCode,
            'response' => $response,
            'messages' => Messages::getMessages(),
        ];

        self::sendJsonResponse($result, $httpCode);
    }

    /**
     * Terminates execution with a successful JSON response.
     */
    final public static function jsonResponse(mixed $response, int $httpCode = 200, string $resultLabel = 'result'): never
    {
        $result = [
            'ok' => true,
            'status' => $httpCode,
            $resultLabel => $response,
            'messages' => Messages::getMessages(),
        ];

        self::sendJsonResponse($result, $httpCode);
    }

    /**
     * Internal helper to send JSON headers and content.
     */
    private static function sendJsonResponse(array $data, int $httpCode): never
    {
        http_response_code($httpCode);
        header('Content-Type: application/json; charset=utf-8');

        echo json_encode(self::appendDebugInfo($data), JSON_THROW_ON_ERROR);
        exit;
    }

    /**
     * Appends backtrace info if debug mode is enabled in config.
     */
    private static function appendDebugInfo(array $info): array
    {
        $config = Config::getConfig();
        $debug = $config->security->debug ?? false;

        if (!$debug) {
            return $info;
        }

        return array_merge($info, [
            'debug' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 5),
        ]);
    }
}
