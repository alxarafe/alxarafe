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

namespace Alxarafe\Domain\Model;

/**
 * EntityId — Typed value object for entity identifiers.
 *
 * Encapsulates the concept of an entity ID, providing type safety
 * and equality semantics. Consuming applications should extend this
 * for their specific entities (e.g., JokeId, UserId).
 *
 * @package Alxarafe\Domain\Model
 */
class EntityId
{
    /**
     * @param int|string $value The raw identifier value.
     */
    public function __construct(
        private readonly int|string $value
    ) {
    }

    /**
     * Get the raw ID value.
     */
    public function value(): int|string
    {
        return $this->value;
    }

    /**
     * Check equality with another EntityId.
     */
    public function equals(self $other): bool
    {
        return $this->value === $other->value;
    }

    /**
     * String representation.
     */
    public function __toString(): string
    {
        return (string) $this->value;
    }
}
