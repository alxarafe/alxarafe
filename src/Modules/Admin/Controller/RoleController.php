<?php

namespace CoreModules\Admin\Controller;

use Alxarafe\Base\Controller\ResourceController;
use CoreModules\Admin\Model\Role;
use Alxarafe\Base\Controller\Trait\ViewTrait;
use CoreModules\Admin\Service\PermissionSyncer;

class RoleController extends ResourceController
{

    #[\Override]
    public static function getModuleName(): string
    {
        return 'Admin';
    }

    #[\Override]
    public static function getControllerName(): string
    {
        return 'Role';
    }

    #[\Override]
    protected function getModelClass()
    {
        return Role::class;
    }

    /**
     * List view properties.
     */
    #[\Override]
    protected function getListColumns(): array
    {
        return [
            'name' => 'Role Name',
            'description' => 'Description',
            'active' => 'Active',
            // 'users_count' => 'Users', 
        ];
    }

    #[\Override]
    protected function getEditFields(): array
    {
        return [
            'name' => 'Role Name',
            'description' => 'Description',
            'active' => 'Active',
        ];
    }

    #[\Override]
    protected function saveRecord()
    {
        // Custom Manual Save to support standard HTML Form POST
        // (Parent implementation expects API/JSON payload)

        try {
            $id = $_POST['id'] ?? null;
            if ($id === 'new' || empty($id)) {
                $role = new Role();
                // Avoid empty ID assignment on new model
            } else {
                $role = Role::find($id);
                if (!$role) {
                    throw new \Exception("Role not found with ID: " . htmlspecialchars((string)$id));
                }
            }

            $role->name = $_POST['name'] ?? '';
            if (empty($role->name)) {
                throw new \Exception("Role Name is required");
            }
            $role->description = $_POST['description'] ?? '';
            $role->active = isset($_POST['active']) ? (int)$_POST['active'] : 1;

            if (!$role->save()) {
                throw new \Exception("Failed to save Role to database.");
            }

            // Update ID if new (for sync)
            $this->recordId = $role->id;

            // 2. Handle Permissions Checkboxes
            if (isset($_POST['save_permissions'])) {
                $permissions = $_POST['permissions'] ?? [];
                if (!is_array($permissions)) {
                    $permissions = [];
                }

                $role->permissions()->sync($permissions);
            }

            // Redirect to List
            \Alxarafe\Lib\Functions::httpRedirect(static::url());
        } catch (\Throwable $e) {
            // In case of fatal error, display it explicitly
            echo "<div style='background: #f8d7da; color: #721c24; padding: 20px; border: 10px solid red; margin: 20px;'>";
            echo "<h1>Fatal Error on Save</h1>";
            echo "<h3>" . $e->getMessage() . "</h3>";
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
            echo "</div>";
            die();
        }
    }

    #[\Override]
    protected function beforeEdit()
    {
        // Load Permissions
        $allPermissions = \CoreModules\Admin\Model\Permission::orderBy('module')
            ->orderBy('controller')
            ->orderBy('action')
            ->get();

        $groupedPermissions = [];
        foreach ($allPermissions as $perm) {
            $groupedPermissions[$perm->module][$perm->controller][] = $perm;
        }

        // Load assigned
        $assignedPermissions = [];
        if ($this->recordId && $this->recordId !== 'new') {
            $role = Role::find($this->recordId);
            if ($role) {
                $this->addVariable('role', $role);
                $assignedPermissions = $role->permissions()->pluck('permissions.id')->toArray();
            }
        }

        $this->addVariable('groupedPermissions', $groupedPermissions);
        $this->addVariable('assignedPermissions', $assignedPermissions);

        // Override template
        $this->setDefaultTemplate('page/role_edit');
    }

    #[\Override]
    protected function beforeList()
    {
        // 1. Fetch all roles for the simple list view
        $roles = Role::all();
        $this->addVariable('roles', $roles);

        // 2. Use custom simple list template (bypassing JS resource)
        $this->setDefaultTemplate('page/role_list');
    }

    /**
     * Custom action: Synchronize Permissions
     */
    public function doSyncPermissions(): void
    {
        $syncer = new PermissionSyncer();
        $report = $syncer->sync();

        echo json_encode(['status' => 'success', 'report' => $report]);
        exit;
    }
}
