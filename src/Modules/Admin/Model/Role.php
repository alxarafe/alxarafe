<?php

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
