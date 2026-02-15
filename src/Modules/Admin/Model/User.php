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
 * @property string|null $token
 * @property bool $is_admin
 * @property int|null $role_id
 * @property string|null $language
 * @property string|null $timezone
 * @property string|null $theme
 * @property string|null $default_page
 * @property string|null $avatar
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
        'role_id',
        'language',
        'timezone',
        'theme',
        'default_page',
        'avatar'
    ];

    /**
     * @var array<string>
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
        'language' => 'string',
        'timezone' => 'string',
        'theme' => 'string',
        'default_page' => 'string',
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
                ->toBase()
                ->map(function ($perm) {
                    return strtolower($perm->module . '.' . $perm->controller . '.' . $perm->action);
                })
                ->toArray();
        }

        $checkKey = strtolower($module . '.' . $controller . '.' . $action);

        return in_array($checkKey, $userPermissions);
    }

    public function getLanguage(): string
    {
        return $this->language ?? \Alxarafe\Base\Config::getConfig()->main->language ?? 'en';
    }

    public function getTimezone(): string
    {
        return $this->timezone ?? \Alxarafe\Base\Config::getConfig()->main->timezone ?? date_default_timezone_get();
    }

    public function getTheme(): string
    {
        return $this->theme ?? \Alxarafe\Base\Config::getConfig()->main->theme ?? 'default';
    }

    public function getDefaultPage(): string
    {
        return $this->default_page ?? 'index.php';
    }

    /**
     * Convert a datetime string or object to the user's timezone.
     * Assumes input is in UTC.
     *
     * @param string|\DateTimeInterface $date
     * @return \Carbon\Carbon
     */
    public function toUserTimezone($date)
    {
        return \Carbon\Carbon::parse($date, 'UTC')->setTimezone($this->getTimezone());
    }

    /**
     * Convert a datetime string or object from user's timezone to UTC.
     *
     * @param string|\DateTimeInterface $date
     * @return \Carbon\Carbon
     */
    public function toUtc($date)
    {
        return \Carbon\Carbon::parse($date, $this->getTimezone())->setTimezone('UTC');
    }
}
