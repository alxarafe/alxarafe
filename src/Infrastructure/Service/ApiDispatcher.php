<?php

declare(strict_types=1);

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

namespace Alxarafe\Infrastructure\Service;

use Alxarafe\Infrastructure\Auth\Auth;
use Alxarafe\Infrastructure\Lib\Trans;
use Modules\Admin\Model\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ApiDispatcher
{
    public function __construct(private ApiRouter $router)
    {
    }

    /**
     * Entry point for an API Request. 
     * Handles routing, authentication, authorization, and execution.
     */
    public function dispatch(): void
    {
        // 1. Get Method and URI
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = $_SERVER['REQUEST_URI'] ?? '/';

        // 2. Find Route
        $route = $this->router->match($method, $uri);

        if (!$route) {
            $this->respondWithError(404, Trans::_('api_route_not_found') ?: 'Route not found');
            return;
        }

        try {
            // 3. Authenticate and Authorize
            $user = $this->authenticateAndAuthorize($route);

            // 4. Execute Controller Method
            $className = $route['class'];
            $functionName = $route['function'];

            // We use reflection/container abstraction. For now, simple instantiation
            $controller = new $className();
            
            // Output buffering to prevent random echoes breaking JSON
            ob_start();
            $response = $controller->$functionName();
            ob_end_clean();

            // If the controller didn't already send a response and exit (e.g. via jsonResponse)
            if ($response !== null) {
                $this->respondWithSuccess($response);
            }
        } catch (ApiException $e) {
            $this->respondWithError($e->getCode(), $e->getMessage());
        } catch (Exception $e) {
            // Log real error internally, return generic 500 for security
            $this->respondWithError(500, Trans::_('api_internal_error') ?: 'Internal Server Error');
        }
    }

    /**
     * Checks JWT Token and permissions.
     * @throws ApiException if forbidden or unauthenticated.
     */
    private function authenticateAndAuthorize(array $route): ?User
    {
        $requiresRoles = !empty($route['roles']);
        $requiresPermissions = !empty($route['permissions']);

        // Quick exit if it's completely public (no roles/perms required)
        if (!$requiresRoles && !$requiresPermissions) {
            return null;
        }

        // 1. Get Token from Header
        $token = $this->getBearerToken();
        if (!$token) {
            throw new ApiException(Trans::_('api_unauthorized') ?: 'Unauthorized: Token missing', 401);
        }

        // 2. Decode Token
        $payload = $this->decodeToken($token);
        if (!$payload) {
            throw new ApiException(Trans::_('api_invalid_token') ?: 'Unauthorized: Invalid token', 401);
        }

        // 3. Find User (RBAC check against DB)
        $username = $payload->data->user ?? null;
        if (!$username) {
            throw new ApiException('Unauthorized: Malformed token payload', 401);
        }

        $user = User::where('name', $username)->first();
        if (!$user) {
            throw new ApiException('Unauthorized: User not found', 401);
        }

        // 4. Validate Roles (RequireRole)
        if ($requiresRoles) {
            $userRole = $user->getRole(); // Assuming ->getRole() or relation ->role exists
            if (!$userRole || !in_array($userRole->name, $route['roles'], true)) {
                throw new ApiException(Trans::_('api_forbidden') ?: 'Forbidden: Insufficient privileges (Role)', 403);
            }
        }

        // 5. Validate Permissions (RequirePermission)
        if ($requiresPermissions) {
            // This implementation depends on how Alxarafe checks granular permissions.
            // Typically Auth::checkPermission($perm, $user) or $user->hasPermission($perm).
            foreach ($route['permissions'] as $perm) {
                if (!$this->userHasPermission($user, $perm)) {
                    throw new ApiException(Trans::_('api_forbidden') ?: 'Forbidden: Missing permission ' . $perm, 403);
                }
            }
        }

        return $user;
    }

    private function getBearerToken(): ?string
    {
        $headers = $this->getAuthorizationHeader();

        if (!empty($headers)) {
            if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }

    private function getAuthorizationHeader(): ?string
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = trim($_SERVER["Authorization"]);
        } elseif (isset($_SERVER['HTTP_AUTHORIZATION'])) {
            $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }

    private function decodeToken(string $jwt): ?object
    {
        try {
            $secretKey = Auth::getSecurityKey();
            if (!$secretKey) {
                return null;
            }
            // Uses HS256 as hardcoded in LoginController previously
            return JWT::decode($jwt, new Key($secretKey, 'HS256'));
        } catch (Exception $e) {
            return null; // Expired, tampered, etc.
        }
    }

    private function userHasPermission(User $user, string $permission): bool
    {
        // TODO: Adapt this to the exact internal RBAC implementation of Alxarafe.
        // For now, mapping a hypothetical method on the Role or User model:
        /** @phpstan-ignore function.impossibleType */
        if (method_exists($user, 'hasPermission')) {
            return $user->hasPermission($permission);
        }
        return false;
    }

    private function respondWithError(int $code, string $message): void
    {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'status' => 'error',
            'code' => $code,
            'message' => $message
        ]);
        exit;
    }

    private function respondWithSuccess(mixed $data): void
    {
        http_response_code(200);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'status' => 'success',
            'data' => $data
        ]);
        exit;
    }
}
