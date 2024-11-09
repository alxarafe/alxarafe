<?php

/* Copyright (C) 2024       Rafael San José         <rsanjose@alxarafe.com>
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

namespace CoreModules\Admin\Api;

use Alxarafe\Base\Controller\ApiController;
use DebugBar\DebugBarException;
use Firebase\JWT\JWT;
use Luracast\Restler\RestException;

class LoginController extends ApiController
{
    /**
     * @url POST /login
     * @throws DebugBarException
     * @throws RestException
     */
    public function __construct()
    {
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        $secret_key = static::getSecurityKey();

        if ($username == 'rsanjose' && $password == 'xxx') {
            $token = [
                'iat' => time(),
                'exp' => time() + (60 * 60),
                'data' => [
                    'username' => $username
                ]
            ];
            return ['token' => JWT::encode($token, $secret_key, 'HS256')];
        } else {
            throw new RestException(401, "Credenciales inválidas");
        }
    }
}
