<?php
/**
 * Copyright (C) 2022-2023  Rafael San José Tovar   <info@rsanjoseo.com>
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

namespace Alxarafe\Controllers;

use Alxarafe\Core\Base\BasicController;
use Alxarafe\Core\Base\View;
use Alxarafe\Core\Singletons\Config;
use Alxarafe\Core\Singletons\FlashMessages;
use Alxarafe\Views\ConfigView;
use DebugBar\DebugBarException;

/**
 * Controller for editing database and skin settings
 *
 * @package Alxarafe\Controllers
 */
class EditConfig extends BasicController
{
    /**
     * Save the form changes in the configuration file
     *
     * @return bool
     */
    public function doSave(): bool
    {
        Config::setVar('constants', 'boolean', 'DEBUG', isset($_POST['debug']));
        Config::setVar('translator', 'main', 'language', $_POST['language'] ?? 'en');
        Config::setVar('templaterender', 'main', 'skin', $_POST['skin'] ?? 'default');
        Config::setVar('database', 'main', 'dbEngineName', $_POST['dbEngineName'] ?? '');
        Config::setVar('database', 'main', 'dbUser', $_POST['dbUser'] ?? '');
        Config::setVar('database', 'main', 'dbPass', $_POST['dbPass'] ?? '');
        Config::setVar('database', 'main', 'dbName', $_POST['dbName'] ?? '');
        Config::setVar('database', 'main', 'dbHost', $_POST['dbHost'] ?? '');
        Config::setVar('database', 'main', 'dbPort', $_POST['dbPort'] ?? '');
        Config::setVar('database', 'main', 'dbPrefix', $_POST['dbPrefix'] ?? '');

        $result = DB::connectToDatabase();
        if (!$result) {
            FlashMessages::setError('database_not_found', 'next');
        }

        $result = Config::saveConfigFile();
        if ($result) {
            FlashMessages::setSuccess('saved', 'next');
            header('location: ' . self::url('Main', 'EditConfig'));
            die();
        }

        return $result;
    }

    /**
     * @throws DebugBarException
     */
    public function setView(): View
    {
        return new ConfigView($this);
    }
}
