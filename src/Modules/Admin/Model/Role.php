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

/**
 * Class Role.
 * Represents a user role in the system.
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property bool $active
 */
class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'name',
        'description',
        'active'
    ];

    /**
     * Users belonging to this role.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Permissions assigned to this role.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id');
    }

    /**
     * Checks if the role has a specific permission.
     * 
     * @param string|int $permission ID or name/key of the permission.
     * @return bool
     */
    public function hasPermission($permission): bool
    {
        // TODO: Implement efficient caching here to avoid N+1 queries
        // For now, we do a direct check.
        // If $permission is an ID:
        if (is_numeric($permission)) {
            return $this->permissions()->where('permissions.id', $permission)->exists();
        }

        // If permission is a key (e.g., 'Admin.User.doEdit')
        // We assume the caller checks by Controller + Action string logic or ID.
        // A robust check depends on how we query permissions.
        // Let's assume we pass the Permission Model or ID for now to be safe.

        return false;
    }
}
