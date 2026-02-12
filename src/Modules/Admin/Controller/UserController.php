<?php

namespace CoreModules\Admin\Controller;

use Alxarafe\Base\Controller\ResourceController;
use CoreModules\Admin\Model\User;
use Alxarafe\Base\Config;
use Alxarafe\Lib\Trans;
use Alxarafe\Lib\Functions;
use CoreModules\Admin\Model\Role;

class UserController extends ResourceController
{
    const MENU = 'admin';
    const SIDEBAR_MENU = [
        ['option' => 'users', 'url' => 'index.php?module=Admin&controller=User']
    ];

    #[\Override]
    public static function getModuleName(): string
    {
        return 'Admin';
    }

    #[\Override]
    public static function getControllerName(): string
    {
        return 'User';
    }

    #[\Override]
    protected function getModelClass()
    {
        return User::class;
    }

    #[\Override]
    protected function getEditFields(): array
    {
        // Not used directly as we have a custom template, but good for reference
        return [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'role_id' => 'Role',
            'language' => 'Language',
            'timezone' => 'Timezone',
            'theme' => 'Theme',
            'is_admin' => 'Administrator'
        ];
    }

    #[\Override]
    protected function beforeEdit()
    {
        // Load data for dropdowns
        $roles = Role::where('active', true)->get();
        $rolesList = [];
        foreach ($roles as $role) {
            $rolesList[$role->id] = $role->name;
        }

        $languages = Trans::getAvailableLanguages();
        $themes = Functions::getThemes();
        $timezones = array_combine(\DateTimeZone::listIdentifiers(), \DateTimeZone::listIdentifiers());

        $user = ($this->recordId && $this->recordId !== 'new') ? User::find($this->recordId) : new User();
        // $this->addVariable('user', $user); // Not needed for generic view

        // --- Fields Definition ---

        // Name & Email (50% each)
        $nameField = new \Alxarafe\Component\Fields\Text('name', Trans::_('name'), [
            'required' => true,
            'value' => $user->name ?? '',
            'col' => 'col-md-6'
        ]);

        $emailField = new \Alxarafe\Component\Fields\Text('email', Trans::_('email'), [
            'type' => 'email',
            'required' => true,
            'value' => $user->email ?? '',
            'col' => 'col-md-6'
        ]);

        // Password (Full width)
        $passPlaceholder = ($this->recordId === 'new') ? 'Required' : 'Leave empty to keep current';
        $passHelp = ($this->recordId !== 'new') ? Trans::_('keep_empty_to_not_change') : '';
        $passwordField = new \Alxarafe\Component\Fields\Text('password', Trans::_('password'), [
            'type' => 'password',
            'placeholder' => $passPlaceholder,
            'help' => $passHelp,
            'col' => 'col-12'
        ]);

        // Role (50%)
        $rolesList = ['' => Trans::_('none')] + $rolesList;
        $roleField = new \Alxarafe\Component\Fields\Select('role_id', Trans::_('role'), $rolesList, [
            'value' => $user->role_id ?? '',
            'col' => 'col-md-6'
        ]);

        // Admin (50%) - Using Boolean/Checkbox
        // Check if Boolean component exists and works. Assuming yes.
        $adminField = new \Alxarafe\Component\Fields\Boolean('is_admin', Trans::_('administrator'), [
            'value' => (bool)($user->is_admin ?? false),
            'col' => 'col-md-6'
        ]);

        // Preferences Fields
        $langField = new \Alxarafe\Component\Fields\Select('language', Trans::_('language'), ['' => Trans::_('default')] + $languages, ['value' => $user->language ?? '']);
        $langField->addAction(
            'fas fa-eraser',
            "this.closest('.input-group').querySelector('select').value = '';",
            Trans::_('default'),
            'btn-outline-secondary',
            \Alxarafe\Component\Enum\ActionPosition::Right
        );

        $systemTz = date_default_timezone_get();
        // Note: Dates must always be stored in UTC and converted to user/system timezone for display.
        $tzField = new \Alxarafe\Component\Fields\Select2('timezone', Trans::_('timezone'), ['' => Trans::_('default') . " ({$systemTz})"] + $timezones, ['value' => $user->timezone ?? '']);
        $tzField->addAction(
            'fas fa-location-arrow',
            "const tz = Intl.DateTimeFormat().resolvedOptions().timeZone; if(tz) { $(this).closest('.input-group').find('select').val(tz).trigger('change'); }",
            Trans::_('detect_timezone'),
            'btn-outline-primary'
        )->addAction(
            'fas fa-eraser',
            "$(this).closest('.input-group').find('select').val('').trigger('change');",
            Trans::_('default'),
            'btn-outline-secondary',
            \Alxarafe\Component\Enum\ActionPosition::Right
        );

        $themeField = new \Alxarafe\Component\Fields\Select('theme', Trans::_('theme'), ['' => Trans::_('default')] + $themes, ['value' => $user->theme ?? '']);
        $themeField->addAction(
            'fas fa-eraser',
            "this.closest('.input-group').querySelector('select').value = '';",
            Trans::_('default'),
            'btn-outline-secondary',
            \Alxarafe\Component\Enum\ActionPosition::Right
        );

        // --- Organize into Panels ---

        $accountPanel = new \Alxarafe\Component\Container\Panel(Trans::_('general'), [
            $nameField,
            $emailField,
            $passwordField,
            $roleField,
            $adminField
        ], ['col' => 'col-md-8']);

        $preferencesPanel = new \Alxarafe\Component\Container\Panel(Trans::_('preferences'), [
            $langField,
            $tzField,
            $themeField
        ], ['col' => 'col-md-4']);

        // Register fields with ResourceController
        $this->setEditFields([
            $accountPanel,
            $preferencesPanel
        ]);

        // Remove manual template setting to use the auto-generated one
        // $this->setDefaultTemplate('page/user_edit');
    }

    #[\Override]
    protected function beforeList()
    {
        $users = User::with('role')->get();
        $this->addVariable('users', $users);
        $this->setDefaultTemplate('page/user_list');
    }

    #[\Override]
    protected function saveRecord()
    {
        try {
            $id = $_POST['id'] ?? null;

            // Handle JSON Input (mirrored from ResourceTrait)
            $contentType = $_SERVER["CONTENT_TYPE"] ?? $_SERVER["HTTP_CONTENT_TYPE"] ?? '';
            $rawInput = file_get_contents('php://input');

            if (stripos($contentType, 'application/json') !== false || ($rawInput && $rawInput[0] === '{')) {
                $json = json_decode($rawInput, true);
                if (is_array($json)) {
                    $_POST = array_merge($_POST, $json);

                    // Re-check ID in case it came in JSON
                    if (empty($id)) {
                        $id = $_POST['id'] ?? null;
                    }
                }
            }

            if ($id === 'new' || empty($id)) {
                $user = new User();
            } else {
                $user = User::find($id);
                if (!$user) {
                    throw new \Exception("User not found with ID: " . htmlspecialchars((string)$id));
                }
            }

            // Basic fields
            if (isset($_POST['name'])) {
                $user->name = $_POST['name'];
            }
            if (isset($_POST['email'])) {
                $user->email = $_POST['email'];
            }

            // Password handling
            $password = $_POST['password'] ?? '';
            if (!empty($password)) {
                $user->password = password_hash($password, PASSWORD_DEFAULT);
            } elseif ($id === 'new') {
                throw new \Exception("Password is required for new users.");
            }

            // Role
            $roleId = $_POST['role_id'] ?? null;
            $user->role_id = ($roleId && $roleId !== '0') ? $roleId : null;

            // Admin
            $user->is_admin = isset($_POST['is_admin']) ? (int)$_POST['is_admin'] : 0;

            // Preferences
            $user->language = !empty($_POST['language']) ? $_POST['language'] : null;
            $user->timezone = !empty($_POST['timezone']) ? $_POST['timezone'] : null;
            $user->theme = !empty($_POST['theme']) ? $_POST['theme'] : null;

            if (!$user->save()) {
                throw new \Exception("Failed to save User to database.");
            }

            $this->recordId = $user->id;

            // Redirect
            Functions::httpRedirect(static::url());
        } catch (\Throwable $e) {
            echo "<div style='background: #f8d7da; color: #721c24; padding: 20px; border: 10px solid red; margin: 20px;'>";
            echo "<h1>Fatal Error on Save</h1>";
            echo "<h3>" . $e->getMessage() . "</h3>";
            echo "<pre>" . $e->getTraceAsString() . "</pre>";
            echo "</div>";
            die();
        }
    }
}
