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

namespace CoreModules\Admin\Model;

use Alxarafe\Base\Model\Model;

/**
 * Class AuditLog.
 * Stores audit trail entries for model operations.
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $model_type   FQCN of the audited model
 * @property string $model_id     Primary key of the audited record
 * @property string $action       'created', 'updated', or 'deleted'
 * @property string|null $old_values  JSON of previous values
 * @property string|null $new_values  JSON of new values
 * @property string|null $ip_address
 * @property string $created_at
 */
class AuditLog extends Model
{
    protected $table = 'audit_logs';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'model_type',
        'model_id',
        'action',
        'old_values',
        'new_values',
        'ip_address',
    ];

    /**
     * Get the user who performed the action.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the audited model instance.
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getAuditedModel()
    {
        $modelClass = $this->model_type;
        if (class_exists($modelClass)) {
            return $modelClass::find($this->model_id);
        }
        return null;
    }

    /**
     * Get decoded old values.
     */
    public function getOldValuesArray(): array
    {
        return $this->old_values ? json_decode($this->old_values, true) : [];
    }

    /**
     * Get decoded new values.
     */
    public function getNewValuesArray(): array
    {
        return $this->new_values ? json_decode($this->new_values, true) : [];
    }

    /**
     * Scope to filter logs for a specific model.
     */
    public function scopeForModel($query, string $modelClass, $modelId = null)
    {
        $query->where('model_type', $modelClass);
        if ($modelId !== null) {
            $query->where('model_id', (string) $modelId);
        }
        return $query;
    }
}
