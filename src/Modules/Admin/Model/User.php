<?php

namespace CoreModules\Admin\Model;

use Alxarafe\Base\Model\Model;
use Illuminate\Database\Capsule\Manager as DB;
use Illuminate\Database\Schema\Blueprint;

/**
 * @method static find($user)
 * @method static where($column, $operator = null, $value = null, $boolean = 'and')
 */
/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $token
 * @property bool $is_admin
 */
final class User extends Model
{
    protected $table = 'users';

    protected $fillable = [
        'name',
        'email',
        'password',
        'token',
        'is_admin',
        'role_id'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'boolean',
        'role_id' => 'integer',
    ];


    public function saveToken($token)
    {
        $this->attributes['token'] = $token;
        return $this->save();
    }

    public function getToken()
    {
        return $this->attributes['token'];
    }

    /**
     * Get the role associated with the user.
     */
    public function role()
    {
        return $this->belongsTo(\CoreModules\Admin\Model\Role::class);
    }

    /**
     * Check if the user has a permission.
     * 
     * @param string $action The action to check (e.g., 'doEdit')
     * @param string|null $controller Optional controller context
     * @param string|null $module Optional module context
     * @return bool
     */
    public function can($action, $controller = null, $module = null): bool
    {
        // 1. Super Admin Bypass
        if ($this->is_admin) {
            return true;
        }

        // 2. No Role assigned -> No Access
        if (!$this->role_id) {
            return false;
        }

        // 3. Check Role Permissions
        // We need to match the current context (Controller/Module) against the permissions table
        if (!$module || !$controller) {
            // If context is missing, we can't check granular permission accurately unless 'action' is a full key.
            return false;
        }

        // Efficient cached check:
        // We should load all permissions for the role once and check in memory.
        // For now, let's assume we do a quick query or cached lookup.

        static $userPermissions = null;

        if ($userPermissions === null) {
            // Load all permissions for this user's role
            // We load the keys: "Module.Controller.Action"
            $userPermissions = \CoreModules\Admin\Model\Permission::query()
                ->select('permissions.module', 'permissions.controller', 'permissions.action')
                ->join('role_permissions', 'permissions.id', '=', 'role_permissions.permission_id')
                ->where('role_permissions.role_id', $this->role_id)
                ->get()
                ->map(function ($perm) {
                    return strtolower($perm->module . '.' . $perm->controller . '.' . $perm->action);
                })
                ->toArray();
        }

        $checkKey = strtolower($module . '.' . $controller . '.' . $action);

        return in_array($checkKey, $userPermissions);
    }
}
