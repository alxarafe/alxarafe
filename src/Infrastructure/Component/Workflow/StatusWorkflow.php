<?php

declare(strict_types=1);

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

namespace Alxarafe\Infrastructure\Component\Workflow;

/**
 * Generic state machine for document/entity lifecycle.
 *
 * Usage:
 *   $wf = new StatusWorkflow();
 *   $wf->addStatus(0, 'Draft', 'badge bg-secondary');
 *   $wf->addStatus(1, 'Validated', 'badge bg-primary');
 *   $wf->addStatus(2, 'Closed', 'badge bg-success');
 *   $wf->addTransition(0, 1, 'validate', 'document.validate');
 *   $wf->addTransition(1, 2, 'close');
 *   $wf->addTransition(1, 0, 'reopen');
 */
class StatusWorkflow
{
    /** @var array<int, array{label: string, cssClass: string}> */
    private array $statuses = [];

    /** @var array<int, array<int, StatusTransition>> */
    private array $transitions = [];

    public function addStatus(int $id, string $label, string $cssClass = 'badge bg-secondary'): self
    {
        $this->statuses[$id] = ['label' => $label, 'cssClass' => $cssClass];
        return $this;
    }

    public function addTransition(
        int $from,
        int $to,
        string $action,
        ?string $permission = null,
        ?string $icon = null,
        ?string $cssClass = null
    ): self {
        $this->transitions[$from][$to] = new StatusTransition($from, $to, $action, $permission, $icon, $cssClass);
        return $this;
    }

    public function getStatusLabel(int $id): string
    {
        return $this->statuses[$id]['label'] ?? 'Unknown';
    }

    public function getStatusCssClass(int $id): string
    {
        return $this->statuses[$id]['cssClass'] ?? '';
    }

    public function getStatuses(): array
    {
        return $this->statuses;
    }

    /**
     * Check if a transition is valid.
     * If $permissionChecker is provided, also verifies the user has the required permission.
     *
     * @param int $from
     * @param int $to
     * @param callable|null $permissionChecker fn(string $permission): bool
     */
    public function canTransition(int $from, int $to, ?callable $permissionChecker = null): bool
    {
        if (!isset($this->transitions[$from][$to])) {
            return false;
        }

        $transition = $this->transitions[$from][$to];
        if ($transition->permission !== null && $permissionChecker !== null) {
            return call_user_func($permissionChecker, $transition->permission);
        }

        return true;
    }

    /**
     * Get all transitions available from a given status.
     *
     * @param int $currentStatus
     * @param callable|null $permissionChecker
     * @return StatusTransition[]
     */
    public function getAvailableTransitions(int $currentStatus, ?callable $permissionChecker = null): array
    {
        if (!isset($this->transitions[$currentStatus])) {
            return [];
        }

        $available = [];
        foreach ($this->transitions[$currentStatus] as $to => $transition) {
            if ($this->canTransition($currentStatus, $to, $permissionChecker)) {
                $available[] = $transition;
            }
        }

        return $available;
    }
}
