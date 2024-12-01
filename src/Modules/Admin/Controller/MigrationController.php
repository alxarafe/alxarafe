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
use Alxarafe\Lib\Routes;

/**
 * Class ConfigController. App settings controller.
 */
class MigrationController extends ViewController
{
    const MENU = 'admin|migrations';

    public function doGetProcesses():void
    {
        $this->template=null;
        $result = array_merge(Config::getMigrations());
        die(json_encode($result));
    }

    public function executeAjaxAction()
    {
        $this->template=null;
        $result = $_POST;
        die(json_encode($result));
    }

    public function doRunMigrationsAndSeeders(): bool
    {
        new Database($this->data->db);

        Config::runMigrations();
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
