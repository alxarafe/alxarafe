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

namespace CoreModules\Admin\Controller;

use Alxarafe\Base\Controller\GenericPublicController;
use Alxarafe\Lib\Auth;
use Alxarafe\Lib\Functions;
use Alxarafe\Lib\Trans;
use Alxarafe\Lib\Messages;
use Alxarafe\Base\Config;
use Alxarafe\Component\Fields\Text;
use Alxarafe\Component\Fields\Select;
use Alxarafe\Component\Fields\Select2;
use Alxarafe\Component\Fields\StaticText;
use Alxarafe\Component\Enum\ActionPosition;
use Alxarafe\Component\Container\Panel;

class ProfileController extends GenericPublicController
{
    #[\Override]
    public static function getModuleName(): string
    {
        return 'Admin';
    }

    #[\Override]
    public static function getControllerName(): string
    {
        return 'Profile';
    }

    #[\Override]
    public function beforeAction(): bool
    {
        if (!Auth::isLogged()) {
            Functions::httpRedirect('index.php');
            return false;
        }
        return parent::beforeAction();
    }

    public function doIndex()
    {
        $this->title = Trans::_('my_profile');
        $user = Auth::$user;

        // No admin context for profile
        $panels = \CoreModules\Admin\Service\UserService::getFormPanels($user, false);

        $this->addVariable('panels', $panels);
        $this->setDefaultTemplate('page/profile');
        return true;
    }

    public function doSave()
    {
        $user = Auth::$user;

        try {
            // Save using service (false = no admin fields)
            if (\CoreModules\Admin\Service\UserService::saveUser($user, $_POST, $_FILES, false)) {
                Messages::addMessage(Trans::_('profile_updated'));
            } else {
                Messages::addError(Trans::_('error_saving'));
            }
        } catch (\Exception $e) {
            Messages::addError($e->getMessage());
        }

        Functions::httpRedirect("index.php?module=Admin&controller=Profile");
        return true;
    }

    public function doSetDefaultPage()
    {
        $user = Auth::$user;
        if ($user) {
            $redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';

            // Robust URL extraction using parse_url
            // This avoids issues if Config::baseUrl doesn't match Referer context exactly.
            $parts = parse_url($redirect);
            $path = ltrim($parts['path'] ?? '', '/');
            $query = $parts['query'] ?? '';

            $urlToSave = $path;
            if ($query) {
                $urlToSave .= '?' . $query;
            }

            // If empty (root), default to index.php
            if (empty($urlToSave)) {
                $urlToSave = 'index.php';
            }

            $user->default_page = $urlToSave;
            if ($user->save()) {
                Messages::addMessage(Trans::_('default_page_updated'));
            } else {
                Messages::addError(Trans::_('error_saving'));
            }

            Functions::httpRedirect($redirect);
        }
        return true;
    }
}
