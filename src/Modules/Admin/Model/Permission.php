<?php

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

namespace CoreModules\Admin\Model;

use Alxarafe\Base\Model\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Permission.
 * Represents a granular action permission in the system.
 * 
 * @property int $id
 * @property string $module
 * @property string $controller
 * @property string $action
 * @property string $name
 */
class Permission extends Model
{
    use SoftDeletes;

    protected $table = 'permissions';

    protected $fillable = [
        'module',
        'controller',
        'action',
        'name',
    ];

    /**
     * Roles that have this permission.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions', 'permission_id', 'role_id');
    }

    /**
     * Helper to get the permission key in format: Module.Controller.Action
     */
    #[\Override]
    public function getKey(): string
    {
        return sprintf('%s.%s.%s', $this->module, $this->controller, $this->action);
    }

    /**
     * Gets the unique identifier for caching purposes.
     * We use "Module.Controller.Action" as standard.
     */
    public static function makeKey(string $module, string $controller, string $action): string
    {
        return sprintf('%s.%s.%s', $module, $controller, $action);
    }
}
