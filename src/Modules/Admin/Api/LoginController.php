<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
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
use Alxarafe\Lib\Auth;
use Alxarafe\Lib\Trans;
use CoreModules\Admin\Model\User;
use Firebase\JWT\JWT;
use Luracast\Restler\RestException;

class LoginController extends ApiController
{
    /**
     * @url POST /login
     * @throws RestException
     */
    public function __construct()
    {
        parent::__construct();

        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];
        $secret_key = Auth::getSecurityKey();
        if ($secret_key === null) {
            self::badApiCall(Trans::_('bad_secret_key'), 401);
        }

        $user = User::where('name', $username)->first();
        if ($user === null || !sodium_crypto_pwhash_str_verify($user->password, $password)) {
            self::badApiCall(Trans::_('bad_api_call'), 401);
        }

        $payload = [
            'iat' => time(),
            'exp' => time() + (60 * 60),
            'data' => [
                'user' => $username
            ]
        ];

        self::jsonResponse(JWT::encode($payload, $secret_key, 'HS256'), 200, 'token');
    }
}
