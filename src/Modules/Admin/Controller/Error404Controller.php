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

use Alxarafe\Base\Controller\GenericPublicController as BasePublicController;

class Error404Controller extends BasePublicController
{
    const MENU = 'admin|info';

    /**
     * Returns the module name for use in url function
     *
     * @return string
     */
    public static function getModuleName(): string
    {
        return 'Admin';
    }

    /**
     * Returns the controller name for use in url function
     *
     * @return string
     */
    public static function getControllerName(): string
    {
        return 'Error404';
    }

    public function doIndex(): bool
    {
        //$this->template = 'page/error404';
        $this->setTemplatesPath(constant('ALX_PATH') . '/Modules/Admin/Templates');
        return true;
    }
}
