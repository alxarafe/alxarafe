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
 * AggregateRoot — Base class for aggregate root entities.
 *
 * Aggregate roots are the primary entry points to domain object clusters.
 * They collect domain events that occurred during business operations,
 * which can be dispatched after persistence.
 *
 * Consuming applications extend this for their main entities
 * (e.g., Joke, Invoice, User).
 *
 * @package Alxarafe\Domain\Model
 */
abstract class AggregateRoot
{
    /**
     * Domain events recorded during this aggregate's lifecycle.
     *
     * @var DomainEvent[]
     */
    private array $domainEvents = [];

    /**
     * Record a domain event.
     *
     * @param DomainEvent $event The event to record.
     */
    protected function recordEvent(DomainEvent $event): void
    {
        $this->domainEvents[] = $event;
    }

    /**
     * Pull all recorded domain events and clear the internal list.
     *
     * Typically called after persisting the aggregate, so that
     * events can be dispatched to subscribers.
     *
     * @return DomainEvent[]
     */
    public function pullDomainEvents(): array
    {
        $events = $this->domainEvents;
        $this->domainEvents = [];
        return $events;
    }

    /**
     * Check if there are any pending domain events.
     */
    public function hasDomainEvents(): bool
    {
        return !empty($this->domainEvents);
    }
}
