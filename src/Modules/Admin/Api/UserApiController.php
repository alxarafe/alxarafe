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
use CoreModules\Admin\Model\User;

/**
 * Class UserApiController.
 *
 * API Endpoint for managing System Users.
 * Provides access to user details via JSON API.
 *
 * @package CoreModules\Admin\Api
 */
class UserApiController extends ApiController
{
    /**
     * Retrieve User details by ID.
     *
     * Fetches user record excluding sensitive fields like password.
     *
     * @param int $id The unique identifier of the user.
     *
     * @return never Outputs JSON response.
     */
    public function get(int $id)
    {
        /** @var User|null $user */
        $user = User::find($id);

        if (!$user) {
            self::badApiCall('User not found', 404);
        }

        self::jsonResponse($user->toArray());
    }
}
