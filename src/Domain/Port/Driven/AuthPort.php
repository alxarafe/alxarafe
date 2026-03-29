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

namespace Alxarafe\Domain\Port\Driven;

/**
 * AuthPort — Secondary (driven) port for authentication and authorization.
 *
 * Abstracts the authentication mechanism so that the application layer
 * does not depend on cookies, sessions, JWT, or any specific implementation.
 *
 * @package Alxarafe\Domain\Port\Driven
 */
interface AuthPort
{
    /**
     * Attempt to authenticate a user with credentials.
     *
     * @param string $username Username or email.
     * @param string $password Plain-text password.
     *
     * @return array<string, mixed>|null User data array on success, null on failure.
     */
    public function authenticate(string $username, string $password): ?array;

    /**
     * Get the currently authenticated user's data.
     *
     * @return array<string, mixed>|null User data array if authenticated, null otherwise.
     */
    public function getAuthenticatedUser(): ?array;

    /**
     * Check if there is a currently authenticated user.
     *
     * @return bool True if a user is authenticated.
     */
    public function isAuthenticated(): bool;

    /**
     * Terminate the current authentication session.
     */
    public function logout(): void;

    /**
     * Check if the authenticated user has a specific permission.
     *
     * @param string $permission The permission identifier (e.g., 'posts.create').
     *
     * @return bool True if the user has the permission.
     */
    public function hasPermission(string $permission): bool;

    /**
     * Check if the authenticated user has a specific role.
     *
     * @param string $role The role identifier (e.g., 'admin').
     *
     * @return bool True if the user has the role.
     */
    public function hasRole(string $role): bool;

    /**
     * Get the authenticated user's unique identifier.
     *
     * @return int|string|null The user ID, or null if not authenticated.
     */
    public function getUserId(): int|string|null;
}
