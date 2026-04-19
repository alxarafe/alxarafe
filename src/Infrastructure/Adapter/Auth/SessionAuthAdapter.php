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

namespace Alxarafe\Infrastructure\Adapter\Auth;

use Alxarafe\Domain\Port\Driven\AuthPort;

/**
 * SessionAuthAdapter — Authentication adapter using PHP native sessions.
 *
 * A clean, session-based auth implementation suitable for new hexagonal apps.
 * Uses PersistencePort for user lookup, no Eloquent dependency.
 *
 * @package Alxarafe\Infrastructure\Adapter\Auth
 */
class SessionAuthAdapter implements AuthPort
{
    private const SESSION_KEY = 'alxarafe_auth_user';

    /**
     * @param \Alxarafe\Domain\Port\Driven\PersistencePort $persistence For user lookups.
     * @param string $usersTable Table name for users.
     */
    public function __construct(
        private readonly \Alxarafe\Domain\Port\Driven\PersistencePort $persistence,
        private readonly string $usersTable = 'users'
    ) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /** @inheritDoc */
    #[\Override]
    public function authenticate(string $username, string $password): ?array
    {
        $user = $this->persistence->findOneBy($this->usersTable, ['name' => $username]);

        if ($user === null) {
            return null;
        }

        if (!password_verify($password, $user['password'] ?? '')) {
            return null;
        }

        // Store user in session
        $_SESSION[self::SESSION_KEY] = $user;

        return $user;
    }

    /** @inheritDoc */
    #[\Override]
    public function getAuthenticatedUser(): ?array
    {
        return $_SESSION[self::SESSION_KEY] ?? null;
    }

    /** @inheritDoc */
    #[\Override]
    public function isAuthenticated(): bool
    {
        return isset($_SESSION[self::SESSION_KEY]);
    }

    /** @inheritDoc */
    #[\Override]
    public function logout(): void
    {
        unset($_SESSION[self::SESSION_KEY]);
    }

    /** @inheritDoc */
    #[\Override]
    public function hasPermission(string $permission): bool
    {
        $user = $this->getAuthenticatedUser();
        if ($user === null) {
            return false;
        }

        // Simple permission check — can be extended by consuming apps
        $permissions = $user['permissions'] ?? [];
        if (is_string($permissions)) {
            $permissions = json_decode($permissions, true) ?? [];
        }

        return in_array($permission, $permissions, true);
    }

    /** @inheritDoc */
    #[\Override]
    public function hasRole(string $role): bool
    {
        $user = $this->getAuthenticatedUser();
        if ($user === null) {
            return false;
        }

        return ($user['role'] ?? '') === $role;
    }

    /** @inheritDoc */
    #[\Override]
    public function getUserId(): int|string|null
    {
        $user = $this->getAuthenticatedUser();
        return $user['id'] ?? null;
    }
}
