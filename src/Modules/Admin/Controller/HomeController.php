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

use Alxarafe\Base\Controller\Controller;
use Alxarafe\Lib\Trans;
use Alxarafe\Attribute\Menu;

/**
 * Class HomeController.
 *
 * Provides the baseline "Inicio" top menu entry that is always visible.
 * CoreModules are never disabled, so this ensures a minimal admin
 * interface is always accessible regardless of application module state.
 *
 * Applications can override this behavior by providing their own
 * top_menu entry with order: 1 in their module controllers.
 */
#[Menu(
    menu: 'top_menu',
    label: 'home',
    icon: 'fas fa-home',
    order: 1
)]
#[Menu(
    menu: 'main_menu',
    label: 'Administration',
    icon: 'fas fa-shield-halved',
    order: 10,
    permission: 'Admin.User.doIndex'
)]
#[Menu(
    menu: 'main_menu',
    label: 'Configuration',
    icon: 'fas fa-cogs',
    order: 20,
    permission: 'Admin.Config.doIndex'
)]
class HomeController extends Controller
{
    #[\Override]
    public static function getModuleName(): string
    {
        return 'Admin';
    }

    #[\Override]
    public static function getControllerName(): string
    {
        return 'Home';
    }

    #[Menu(
        menu: 'main_menu',
        label: 'Dashboard',
        icon: 'fas fa-tachometer-alt',
        order: 1
    )]
    public function doIndex(): bool
    {
        $this->addVariable('title', Trans::_('Dashboard'));
        $this->setDefaultTemplate('page/admin_home');
        return true;
    }
}
