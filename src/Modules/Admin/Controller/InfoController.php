<?php

/* Copyright (C) 2024       Rafael San José         <rsanjose@alxarafe.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace CoreModules\Admin\Controller;

use Alxarafe\Base\Controller\GenericPublicController;
use Alxarafe\Lib\Auth;

use Alxarafe\Attribute\Menu;

#[Menu(
    menu: 'admin_sidebar',
    label: 'Info',
    icon: 'fa-info-circle',
    order: 100,
    permission: 'Admin.Info.doIndex'
)]
class InfoController extends GenericPublicController
{


    public function __construct()
    {
        parent::__construct();

        // Check if user is logged in to personalize the page if needed, 
        // but it's now public.
        // If we want to allow public access but show user info if logged in:
        Auth::isLogged();
    }

    /**
     * Returns the module name for use in url function
     *
     * @return string
     */
    #[\Override]
    public static function getModuleName(): string
    {
        return 'Admin';
    }

    /**
     * Returns the controller name for use in url function
     *
     * @return string
     */
    #[\Override]
    public static function getControllerName(): string
    {
        return 'Info';
    }

    public function doIndex(): bool
    {
        //$this->template = 'page/info';
        return true;
    }
}
