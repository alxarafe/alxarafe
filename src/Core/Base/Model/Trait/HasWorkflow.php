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

namespace Alxarafe\Base\Model\Trait;

/**
 * Trait HasWorkflow — State machine for document lifecycle.
 *
 * Provides state management for models that have a status/workflow field
 * (e.g., Draft → Validated → Closed → Cancelled), typical in Dolibarr entities.
 *
 * Usage:
 *   class Order extends Model {
 *       use HasWorkflow;
 *       protected array $states = [
 *           0  => ['label' => 'Borrador', 'transitions' => [1]],
 *           1  => ['label' => 'Validado', 'transitions' => [2, -1]],
 *           2  => ['label' => 'Cerrado',  'transitions' => []],
 *           -1 => ['label' => 'Anulado',  'transitions' => [0]],
 *       ];
 *       protected string $stateField = 'fk_statut';
 *   }
 *
 * Optional permission integration:
 *   protected array $statePermissions = [
 *       '0->1' => 'order.validate',
 *       '1->-1' => 'order.cancel',
 *   ];
 */
/** @phpstan-ignore trait.unused */
trait HasWorkflow
{
    /**
     * Optional custom checker.
     * @var callable|null
     */
    protected $permissionChecker = null;

    /**
     * Get the workflow states definition.
     *
     * Models MUST define a $states property or override this method.
     *
     * @return array<int, array{label: string, transitions: int[]}>
     */
    public function getStates(): array
    {
        return $this->states ?? [];
    }

    /**
     * Get the database field that stores the current state.
     *
     * Defaults to 'fk_statut' (Dolibarr convention).
     */
    public function getStateField(): string
    {
        return $this->stateField ?? 'fk_statut';
    }

    /**
     * Get the current state ID.
     */
    public function getCurrentState(): int
    {
        return (int) ($this->{$this->getStateField()} ?? 0);
    }

    /**
     * Get the label for the current state.
     */
    public function getCurrentStateLabel(): string
    {
        $states = $this->getStates();
        $current = $this->getCurrentState();

        return $states[$current]['label'] ?? 'Unknown';
    }

    /**
     * Check if a transition to the given state is allowed.
     *
     * Validates:
     * 1. The target state exists in the states definition
     * 2. The transition is allowed from the current state
     * 3. Required permissions are met (if defined)
     *
     * @param int $to Target state ID
     * @return bool
     */
    public function canTransition(int $to): bool
    {
        $states = $this->getStates();
        $current = $this->getCurrentState();

        // Target state must exist
        if (!isset($states[$to])) {
            return false;
        }

        // Current state must exist
        if (!isset($states[$current])) {
            return false;
        }

        // Transition must be in the allowed list
        if (!in_array($to, $states[$current]['transitions'], true)) {
            return false;
        }

        // Check permissions if defined
        if (!$this->checkTransitionPermission($current, $to)) {
            return false;
        }

        return true;
    }

    /**
     * Execute a transition to the given state.
     *
     * Updates the state field and saves the model.
     * Returns false if the transition is not allowed.
     *
     * @param int $to Target state ID
     * @return bool True if transition was successful
     */
    public function transition(int $to): bool
    {
        if (!$this->canTransition($to)) {
            return false;
        }

        $this->{$this->getStateField()} = $to;

        // If the model has a save method (Eloquent), call it
        if (method_exists($this, 'save')) {
            return $this->save();
        }

        return true;
    }

    /**
     * Get all available transitions from the current state.
     *
     * Returns only transitions that are currently allowed
     * (including permission checks).
     *
     * @return array<int, array{id: int, label: string}>
     */
    public function getAvailableTransitions(): array
    {
        $states = $this->getStates();
        $current = $this->getCurrentState();

        if (!isset($states[$current])) {
            return [];
        }

        $available = [];
        foreach ($states[$current]['transitions'] as $targetId) {
            if (isset($states[$targetId]) && $this->canTransition($targetId)) {
                $available[] = [
                    'id' => $targetId,
                    'label' => $states[$targetId]['label'],
                ];
            }
        }

        return $available;
    }

    /**
     * Check if a specific transition is permitted.
     *
     * Looks for permission requirements in `$statePermissions` property.
     * Format: ['from->to' => 'permission.string']
     *
     * If no permissions are defined, all valid transitions are allowed.
     * If a permission checker is not available, transitions are allowed.
     *
     * @param int $from Source state ID
     * @param int $to   Target state ID
     * @return bool
     */
    protected function checkTransitionPermission(int $from, int $to): bool
    {
        // If no permissions defined, allow all valid transitions
        if (!isset($this->statePermissions) || empty($this->statePermissions)) {
            return true;
        }

        $key = $from . '->' . $to;

        // If this specific transition has no permission requirement, allow it
        if (!isset($this->statePermissions[$key])) {
            return true;
        }

        $requiredPermission = $this->statePermissions[$key];

        // Try the framework's permission system
        if (class_exists('\\Alxarafe\\Lib\\Auth') && method_exists('\\Alxarafe\\Lib\\Auth', 'hasPermission')) {
            /** @var callable $checker */
            $checker = ['\\Alxarafe\\Lib\\Auth', 'hasPermission'];
            return (bool) call_user_func($checker, $requiredPermission);
        }

        // If permission checker is a callable set on the model
        if (isset($this->permissionChecker) && is_callable($this->permissionChecker)) {
            return call_user_func($this->permissionChecker, $requiredPermission);
        }

        // No permission system available → allow (backward compatible)
        return true;
    }

    /**
     * Set a custom permission checker callable.
     *
     * @param callable $checker Function that receives a permission string and returns bool
     * @return static
     */
    public function setPermissionChecker(callable $checker): static
    {
        $this->permissionChecker = $checker;
        return $this;
    }

    /**
     * Check if the model has a workflow definition.
     */
    public function hasWorkflow(): bool
    {
        return !empty($this->getStates());
    }

    /**
     * Check if the model is in a specific state.
     *
     * @param int $stateId State ID to check
     */
    public function isInState(int $stateId): bool
    {
        return $this->getCurrentState() === $stateId;
    }
}
