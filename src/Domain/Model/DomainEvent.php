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
 * DomainEvent — Base class for domain events.
 *
 * Domain events represent something meaningful that happened in the domain.
 * They are immutable records of facts. Consuming applications extend this
 * for their specific events (e.g., JokePublished, UserRegistered).
 *
 * @package Alxarafe\Domain\Model
 */
abstract class DomainEvent
{
    /**
     * When the event occurred.
     */
    private readonly \DateTimeImmutable $occurredAt;

    /**
     * Unique event identifier.
     */
    private readonly string $eventId;

    public function __construct()
    {
        $this->occurredAt = new \DateTimeImmutable();
        $this->eventId = bin2hex(random_bytes(16));
    }

    /**
     * Get the event name (typically the class short name).
     */
    public function eventName(): string
    {
        $parts = explode('\\', static::class);
        return end($parts);
    }

    /**
     * When the event occurred.
     */
    public function occurredAt(): \DateTimeImmutable
    {
        return $this->occurredAt;
    }

    /**
     * Unique identifier for this event instance.
     */
    public function eventId(): string
    {
        return $this->eventId;
    }

    /**
     * Serialize the event payload to an array.
     * Each concrete event must implement this.
     *
     * @return array<string, mixed>
     */
    abstract public function toArray(): array;
}
