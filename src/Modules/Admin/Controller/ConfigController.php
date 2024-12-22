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
use Alxarafe\Lib\Functions;
use Alxarafe\Lib\Messages;
use Alxarafe\Lib\Trans;
use Alxarafe\Tools\ModuleManager;
use DebugBar\DebugBarException;
use stdClass;

/**
 * Class ConfigController. App settings controller.
 */
class ConfigController extends ViewController
{
    const MENU = 'admin|config';
    const SIDEBAR_MENU = [
        ['option' => 'admin|auth|logout', 'url' => 'index.php?module=Admin&controller=Auth&method=logout'],
        ['option' => 'general', 'url' => 'index.php?module=Admin&controller=Config&method=general'],
        ['option' => 'appearance', 'url' => 'index.php?module=Admin&controller=Config&method=appearance'],
        ['option' => 'security', 'url' => 'index.php?module=Admin&controller=Config&method=security']
    ];

    /**
     * Configuration file information
     *
     * @var stdClass
     */
    public $data;

    /**
     * Array with availables languages
     *
     * @var array
     */
    public $languages;
    public $themes;
    public $dbtypes;

    public $db_create;
    public bool $pdo_connection;
    public bool $pdo_db_exists;

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
        return 'Config';
    }

    public function beforeAction(): bool
    {
        $this->getPost();

        $this->languages = Trans::getAvailableLanguages();
        $this->themes = Functions::getThemes();
        $this->dbtypes = Database::getDbDrivers();

        Trans::setLang($this->config->main->language ?? Trans::FALLBACK_LANG);

        $this->checkDatabaseStatus();

        return parent::beforeAction();
    }

    /**
     * Sets $data with the information sent by POST
     *
     * @return void
     */
    private function getPost(): void
    {
        $this->data = Config::getConfig();
        if (!isset($this->data)) {
            $this->data = new stdClass();
        }

        foreach (Config::CONFIG_STRUCTURE as $section => $values) {
            if (!isset($this->data->{$section})) {
                $this->data->{$section} = new stdClass();
            }
            foreach ($values as $variable) {
                $value = Functions::getIfIsset($variable, $this->data->{$section}->{$variable} ?? '');
                if (!isset($value)) {
                    continue;
                }
                $this->data->{$section}->{$variable} = $value;
            }
        }

        $this->db_create = filter_input(INPUT_POST, 'db_create');
    }

    private function checkDatabaseStatus()
    {
        $this->pdo_connection = Database::checkConnection($this->data->db);
        $this->pdo_db_exists = Database::checkIfDatabaseExists($this->data->db);
        if (!$this->pdo_connection) {
            Messages::addAdvice(Trans::_('pdo_connection_error'));
        } elseif (!$this->pdo_db_exists) {
            Messages::addAdvice(Trans::_('pdo_db_connection_error', ['db' => $this->data->db->name]));
        }
    }

    /**
     * The 'index' action: Default action
     *
     * @return bool
     */
    public function doIndex(): bool
    {
        /**
         * TODO: The value of this variable will be filled in when the roles
         *       are correctly implemented.
         */
        $restricted_access = false;

        if (isset($this->config) && $restricted_access) {
            $this->template = 'page/forbidden';
        }

        return true;
    }

    /**
     * The 'createDatabase' action: Creates the database
     *
     * @return bool
     */
    public function doCreateDatabase(): bool
    {
        if (!Database::createDatabaseIfNotExists($this->data->db)) {
            Messages::addError(Trans::_('error_connecting_database', ['db' => $this->data->db->name]));
            return true;
        }
        Messages::addMessage(Trans::_('successful_connection_database', ['db' => $this->data->db->name]));
        return false;
    }

    public function doGoMigrations(): void
    {
        Functions::httpRedirect(MigrationController::url());
    }

    /**
     * CheckConnection action.
     *
     * @return bool
     * @throws DebugBarException
     */
    public function doCheckConnection(): bool
    {
        $ok = Database::checkDatabaseConnection($this->data->db, $this->db_create);
        if (!$ok) {
//            $messages = Messages::getMessages();
//            foreach ($messages as $message) {
//                Messages::addAdvice($message);
//            }
            Messages::addError(Trans::_('error_connecting_database', ['db' => $this->data->db->name]));
            return true;
        }
        Messages::addMessage(Trans::_('successful_connection_database', ['db' => $this->data->db->name]));

        return static::doRunMigrationsAndSeeders();
    }

    public function doRunMigrationsAndSeeders(): bool
    {
        new Database($this->data->db);

        Config::runMigrations();
        Config::runSeeders();

        return true;
    }

    /**
     * Save action.
     *
     * @return bool
     * @throws DebugBarException
     */
    public function doSave(): bool
    {
        if (!config::setConfig($this->data)) {
            Messages::addError(Trans::_('error_saving_settings'));
            return false;
        }

        Messages::addMessage(Trans::_('settings_saved_successfully'));
        return true;
    }

    public function doExit(): void
    {
        Functions::httpRedirect(PublicController::url());
    }

    public function doRegenerate()
    {
        ModuleManager::regenerate();
        return true;
    }
}
