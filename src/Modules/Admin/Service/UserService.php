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

namespace CoreModules\Admin\Service;

use Alxarafe\Component\Container\Panel;
use Alxarafe\Component\Fields\Boolean;
use Alxarafe\Component\Fields\Select;
use Alxarafe\Component\Fields\Select2;
use Alxarafe\Component\Fields\StaticText;
use Alxarafe\Component\Fields\Text;
use Alxarafe\Base\Config;
use Alxarafe\Lib\Trans;
use Alxarafe\Lib\Functions;
use CoreModules\Admin\Model\Role;
use CoreModules\Admin\Model\User;
use Alxarafe\Component\Enum\ActionPosition;

class UserService
{
    /**
     * Builds the form fields for User editing.
     * 
     * @param User $user The user model instance.
     * @param bool $isAdminContext If true, allows editing Admin/Role fields.
     */
    public static function getFormPanels(User $user, bool $isAdminContext = false): array
    {
        // --- Dependencies ---
        $roles = Role::where('active', true)->get();
        $rolesList = [];
        foreach ($roles as $role) {
            /** @var Role $role */
            $rolesList[$role->id] = $role->name;
        }

        $languages = Trans::getAvailableLanguages();
        $themes = Functions::getThemes();
        $timezones = array_combine(\DateTimeZone::listIdentifiers(), \DateTimeZone::listIdentifiers());
        $systemTz = date_default_timezone_get();

        // --- Fields Definition ---

        // Name & Email
        $nameField = new Text('name', Trans::_('name'), [
            'required' => true,
            'value' => $user->name ?? '',
            'col' => 'col-md-6'
        ]);

        $emailField = new Text('email', Trans::_('email'), [
            'type' => 'email',
            'required' => true,
            'value' => $user->email ?? '',
            'col' => 'col-md-6'
        ]);

        // Password
        $isNew = empty($user->id);
        $passPlaceholder = $isNew ? 'Required' : 'Leave empty to keep current';
        $passHelp = !$isNew ? Trans::_('keep_empty_to_not_change') : '';
        $passwordField = new Text('password', Trans::_('password'), [
            'type' => 'password',
            'placeholder' => $passPlaceholder,
            'help' => $passHelp,
            'col' => 'col-12'
        ]);

        // Role & Admin (Only if Admin Context)
        $fieldsAccount = [$nameField, $emailField, $passwordField];

        if ($isAdminContext) {
            $rolesList = ['' => Trans::_('none')] + $rolesList;
            $roleField = new Select('role_id', Trans::_('role'), $rolesList, [
                'value' => $user->role_id ?? '',
                'col' => 'col-md-6'
            ]);

            $adminField = new Boolean('is_admin', Trans::_('administrator'), [
                'value' => (bool)($user->is_admin ?? false),
                'col' => 'col-md-6'
            ]);

            $fieldsAccount[] = $roleField;
            $fieldsAccount[] = $adminField;
        }

        // Preferences
        $langField = new Select('language', Trans::_('language'), ['' => Trans::_('default')] + $languages, ['value' => $user->language ?? '']);
        $langField->addAction('fas fa-eraser', "this.closest('.input-group').querySelector('select').value = '';", Trans::_('default'), 'btn-outline-secondary', ActionPosition::Right);

        $tzField = new Select2('timezone', Trans::_('timezone'), ['' => Trans::_('default')] + $timezones, ['value' => $user->timezone ?? '']);
        $tzField->addAction('fas fa-location-arrow', "const tz = Intl.DateTimeFormat().resolvedOptions().timeZone; if(tz) { $(this).closest('.input-group').find('select').val(tz).trigger('change'); }", Trans::_('detect_timezone'), 'btn-outline-primary')
            ->addAction('fas fa-eraser', "$(this).closest('.input-group').find('select').val('').trigger('change');", Trans::_('default'), 'btn-outline-secondary', ActionPosition::Right);

        $themeField = new Select('theme', Trans::_('theme'), ['' => Trans::_('default')] + $themes, ['value' => $user->theme ?? '']);
        $themeField->addAction('fas fa-eraser', "this.closest('.input-group').querySelector('select').value = '';", Trans::_('default'), 'btn-outline-secondary', ActionPosition::Right);

        $defaultPageField = new Text('default_page', Trans::_('default_page'), [
            'value' => $user->default_page ?? '',
            'help' => Trans::_('default_page_help')
        ]);

        // Avatar
        $currentAvatar = '';
        if (!empty($user->avatar) && file_exists(Config::getPublicRoot() . '/' . $user->avatar)) {
            $currentAvatar = '<div class="mb-2"><img src="' . $user->avatar . '" class="img-thumbnail" style="max-height: 150px;"></div>';
        }

        $avatarDisplay = new StaticText($currentAvatar, ['col' => 'col-12']);
        $avatarUpload = new Text('avatar_upload', Trans::_('avatar'), [
            'type' => 'file',
            'accept' => 'image/*',
            'col' => 'col-12',
            'help' => Trans::_('upload_avatar_help')
        ]);

        // Panels
        $accountPanel = new Panel(Trans::_('title_user_general'), $fieldsAccount, ['col' => 'col-md-8']);
        $preferencesPanel = new Panel(Trans::_('title_user_preferences'), [$langField, $tzField, $themeField, $defaultPageField], ['col' => 'col-md-4']);
        $avatarPanel = new Panel(Trans::_('avatar'), [$avatarDisplay, $avatarUpload], ['col' => 'col-md-12']);

        return [
            $accountPanel,
            $preferencesPanel,
            $avatarPanel
        ];
    }
    public static function saveUser(User $user, array $data, array $files, bool $isAdminContext = false): bool
    {
        // Name & Email
        if (isset($data['name'])) $user->name = $data['name'];
        if (isset($data['email'])) $user->email = $data['email'];

        // Password
        $password = $data['password'] ?? '';
        if (!empty($password)) {
            $user->password = password_hash($password, PASSWORD_DEFAULT);
        } elseif (!$user->exists && empty($user->password)) { // New user must have password
            throw new \Exception("Password is required for new users.");
        }

        // Role & Admin (Only if Admin Context)
        if ($isAdminContext) {
            $roleId = $data['role_id'] ?? null;
            $user->role_id = $roleId ? (int)$roleId : null;
            // Boolean field sends '1' or nothing
            $user->is_admin = isset($data['is_admin']) ? (bool)$data['is_admin'] : false;
        }

        // Preferences
        $user->language = !empty($data['language']) ? $data['language'] : null;
        $user->timezone = !empty($data['timezone']) ? $data['timezone'] : null;
        $user->theme = !empty($data['theme']) ? $data['theme'] : null;
        $user->default_page = !empty($data['default_page']) ? $data['default_page'] : null;

        // Avatar
        if (isset($files['avatar_upload']) && $files['avatar_upload']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/avatars/';
            $publicRoot = Config::getPublicRoot();
            $targetDir = $publicRoot . '/' . $uploadDir;
            if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);

            $fileName = $files['avatar_upload']['name'];
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $dest_path = $targetDir . $newFileName;

            if (move_uploaded_file($files['avatar_upload']['tmp_name'], $dest_path)) {
                if (!empty($user->avatar) && file_exists($publicRoot . '/' . $user->avatar)) {
                    unlink($publicRoot . '/' . $user->avatar);
                }
                $user->avatar = $uploadDir . $newFileName;
            }
        }

        return $user->save();
    }
}
