<?php
/**
 * Copyright (C) 2021-2021  Rafael San José Tovar   <info@rsanjoseo.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Alxarafe\Modules\Main\Controllers;

use Alxarafe\Core\Base\Controller;
use Alxarafe\Core\Base\View;
use Alxarafe\Core\Singletons\Config;
use Alxarafe\Modules\Main\Views\ConfigView;

/**
 * Controller for editing database and skin settings
 *
 * @package Alxarafe\Controllers
 */
class EditConfig extends Controller
{
    /**
     * Save the form changes in the configuration file
     *
     * @return void
     */
    public function doSave()
    {

        $config = Config::getInstance();
        $config->setVar('constants', 'boolean', 'DEBUG', isset($_POST['debug']));
        $config->setVar('translator', 'main', 'language', $_POST['language'] ?? 'en');
        $config->setVar('templaterender', 'main', 'skin', $_POST['skin'] ?? 'default');
        $config->setVar('database', 'main', 'dbEngineName', $_POST['dbEngineName'] ?? '');
        $config->setVar('database', 'main', 'dbUser', $_POST['dbUser'] ?? '');
        $config->setVar('database', 'main', 'dbPass', $_POST['dbPass'] ?? '');
        $config->setVar('database', 'main', 'dbName', $_POST['dbName'] ?? '');
        $config->setVar('database', 'main', 'dbHost', $_POST['dbHost'] ?? '');
        $config->setVar('database', 'main', 'dbPort', $_POST['dbPort'] ?? '');
        $config->setVar('database', 'main', 'dbPrefix', $_POST['dbPrefix'] ?? '');

        $config->saveConfigFile();
    }

    /**
     * @throws \DebugBar\DebugBarException
     */
    public function setView(): View
    {
        return new ConfigView($this);
    }
}
