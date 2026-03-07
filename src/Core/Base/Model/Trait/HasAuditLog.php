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

use CoreModules\Admin\Model\AuditLog;

/**
 * Trait HasAuditLog.
 *
 * Automatically logs create/update/delete operations on a model.
 * Stores entries in the audit_logs table with old and new values,
 * the acting user, and the IP address.
 *
 * Usage:
 *   class Invoice extends Model {
 *       use HasAuditLog;
 *   }
 *
 * Optional customization:
 *   - Override getAuditExcludedFields() to exclude sensitive fields
 *   - Override shouldAudit() to conditionally disable auditing
 */
/** @phpstan-ignore trait.unused */
trait HasAuditLog
{
    /**
     * Boot the HasAuditLog trait.
     * Registers Eloquent model events for automatic audit logging.
     */
    public static function bootHasAuditLog(): void
    {
        // Log creation
        static::created(function ($model) {
            if ($model->shouldAudit()) {
                $model->logAudit('created', [], $model->getAuditableAttributes());
            }
        });

        // Log update (capture old and new values)
        static::updating(function ($model) {
            if ($model->shouldAudit()) {
                // Store the original values before change (for logging in 'updated' event)
                $model->_auditOldValues = $model->getOriginal();
            }
        });

        static::updated(function ($model) {
            if ($model->shouldAudit()) {
                $oldValues = $model->_auditOldValues ?? [];
                $newValues = $model->getAuditableAttributes();

                // Only log if there are actual changes
                $changes = $model->getChanges();
                if (!empty($changes)) {
                    $filteredOld = array_intersect_key($oldValues, $changes);
                    $filteredNew = array_intersect_key($newValues, $changes);
                    $model->logAudit('updated', $filteredOld, $filteredNew);
                }
            }
        });

        // Log deletion
        static::deleted(function ($model) {
            if ($model->shouldAudit()) {
                $model->logAudit('deleted', $model->getAuditableAttributes(), []);
            }
        });
    }

    /**
     * Determine whether auditing is enabled for this model instance.
     * Override in the model to disable auditing conditionally.
     */
    protected function shouldAudit(): bool
    {
        return true;
    }

    /**
     * Get the list of fields to exclude from audit logs.
     * Override in the model to exclude sensitive fields.
     *
     * @return array List of field names to exclude
     */
    protected function getAuditExcludedFields(): array
    {
        return ['password', 'remember_token', 'created_at', 'updated_at'];
    }

    /**
     * Get the model attributes filtered for audit logging.
     *
     * @return array
     */
    private function getAuditableAttributes(): array
    {
        $attributes = $this->getAttributes();
        $excluded = $this->getAuditExcludedFields();

        return array_diff_key($attributes, array_flip($excluded));
    }

    /**
     * Create an audit log entry.
     *
     * @param string $action    One of: 'created', 'updated', 'deleted'
     * @param array  $oldValues Previous values
     * @param array  $newValues New values
     */
    private function logAudit(string $action, array $oldValues, array $newValues): void
    {
        try {
            $userId = null;
            if (class_exists('\Alxarafe\Lib\Auth') && property_exists('\Alxarafe\Lib\Auth', 'user')) {
                $user = \Alxarafe\Lib\Auth::$user;
                $userId = $user ? ($user->id ?? null) : null;
            }

            $ipAddress = $_SERVER['REMOTE_ADDR'] ?? null;

            AuditLog::create([
                'user_id' => $userId,
                'model_type' => static::class,
                'model_id' => (string) $this->getKey(),
                'action' => $action,
                'old_values' => !empty($oldValues) ? json_encode($oldValues) : null,
                'new_values' => !empty($newValues) ? json_encode($newValues) : null,
                'ip_address' => $ipAddress,
            ]);
        } catch (\Throwable $e) {
            // Never let audit logging break the main operation
            error_log('AuditLog error: ' . $e->getMessage());
        }
    }
}
