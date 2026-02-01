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

use Alxarafe\Base\Config;
use Alxarafe\Base\Controller\ViewController;
use Alxarafe\Base\Database;
use Alxarafe\Lib\Messages;
use Alxarafe\Lib\Trans;

/**
 * Class ConfigController. App settings controller.
 */
class MigrationController extends ViewController
{
    const MENU = 'admin|migrations';

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
        return 'Migration';
    }

    public function doGetProcesses(): void
    {
        $this->template = null;
        $migrations = array_merge(Config::getMigrations());
        $result = [];
        foreach ($migrations as $key => $migration) {
            $data = explode("@", $key);
            if (count($data) < 2) {
                continue;
            }
            $class = $data[0];
            $module = $data[1];
            $result[] = [
                'class' => $class,
                'module' => $module,
                'migration' => $migration,
                'message' => Trans::_('processing_migration', ['name' => $module . '::' . $class]),
            ];
        }
        die(json_encode($result));
    }

    public function doExecuteProcess(): void
    {
        $this->template = null;
        $result = [
            'status' => 'success',
            'message' => 'Processed successfully ' . $_POST['module'] . '::' . $_POST['class']
        ];
        die(json_encode($result));
    }

    public function doRunMigrationsAndSeeders(): bool
    {
        Config::doRunMigrations();
        Config::runSeeders();

        return true;
    }

    public function doExit()
    {
        /**
         * TODO: Loads public page
         */
        $this->template = 'page/public';
        return true;
    }
}
