<?php

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
