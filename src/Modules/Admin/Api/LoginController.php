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

namespace CoreModules\Admin\Api;

use Alxarafe\Base\Controller\ApiController;
use Alxarafe\Lib\Auth;
use Alxarafe\Lib\Trans;
use CoreModules\Admin\Model\User;
use Firebase\JWT\JWT;
use Alxarafe\Attribute\ApiRoute;

class LoginController extends ApiController
{
    #[ApiRoute(path: '/api/login', method: 'POST')]
    public function login(): array
    {
        $username = $_REQUEST['username'] ?? '';
        $password = $_REQUEST['password'] ?? '';
        $secret_key = Auth::getSecurityKey();
        
        if ($secret_key === null) {
            self::badApiCall(Trans::_('bad_secret_key') ?: 'Secret key not found', 500);
        }

        $user = User::where('name', $username)->first();
        if ($user === null || !password_verify($password, $user->password)) {
            self::badApiCall(Trans::_('bad_api_call') ?: 'Invalid credentials', 401);
        }

        $payload = [
            'iat' => time(),
            'exp' => time() + (60 * 60 * 24), // 24 hours token
            'data' => [
                'user' => $username,
                'role' => $user->getRole()->name ?? 'user'
            ]
        ];

        // ApiDispatcher will wrap this return in a { "status": "success", "data": ... } payload
        return [
            'token' => JWT::encode($payload, $secret_key, 'HS256')
        ];
    }
}
