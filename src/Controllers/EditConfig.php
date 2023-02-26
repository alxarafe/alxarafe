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
use Alxarafe\Core\Singletons\Config;
use Alxarafe\Core\Singletons\FlashMessages;
use Alxarafe\Core\Singletons\Render;
use Alxarafe\Core\Singletons\Translator;
use Alxarafe\Database\DB;
use Alxarafe\Database\Engine;

/**
 * Controller for editing database and skin settings
 *
 * @package Alxarafe\Controllers
 */
class EditConfig extends BasicController
{
    public $language;

    public $checkDebug;

    public function main(): void
    {
        $this->dbEngines = Engine::getEngines();
        $this->dbEngineName = Config::getVar('database', 'main', 'dbEngineName') ?? $this->dbEngines[0] ?? '';

        $this->skins = Render::getSkins();
        $this->skin = Config::getVar('templaterender', 'main', 'skin') ?? $this->skins[0] ?? '';

        $this->checkDebug = Config::getVar('constants', 'boolean', 'DEBUG') ?? false;

        $this->languages = Translator::getAvailableLanguages();
        $this->language = Config::getVar('translator', 'main', 'language') ?? key($this->languages) ?? 'es';

        $this->dbConfig['dbUser'] = Config::getVar('database', 'main', 'dbUser') ?? 'root';
        $this->dbConfig['dbPass'] = Config::getVar('database', 'main', 'dbPass') ?? '';
        $this->dbConfig['dbName'] = Config::getVar('database', 'main', 'dbName') ?? 'alxarafe';
        $this->dbConfig['dbHost'] = Config::getVar('database', 'main', 'dbHost') ?? 'localhost';
        $this->dbConfig['dbPrefix'] = Config::getVar('database', 'main', 'dbPrefix') ?? 'tc_';
        $this->dbConfig['dbPort'] = Config::getVar('database', 'main', 'dbPort') ?? '';

        parent::main();
    }

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

    public function setTemplate(): string
    {
        return 'config';
    }
}
