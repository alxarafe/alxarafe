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
use Alxarafe\Base\Database;
use Alxarafe\Lib\Functions;
use Alxarafe\Lib\Trans;
use stdClass;
use Alxarafe\Base\Controller\ResourceController;
use Alxarafe\Component\Fields\Select;
use Alxarafe\Component\Fields\Text;
use Alxarafe\Component\Fields\Boolean;

/**
 * Class ConfigController. App settings controller.
 */
class ConfigController extends ResourceController
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

    protected function getModelClass()
    {
        // Config is not a standard Eloquent Model, but we can treat it specially in handleRequest/fetchRecordData
        return 'Alxarafe\Base\Config';
    }

    protected function setup()
    {
        // Add custom buttons for Config
        $this->addEditButton('save', Trans::_('save_configuration'), 'fas fa-save', 'primary', 'left', 'action');

        if ($this->pdo_connection) {
            if (!$this->pdo_db_exists) {
                $this->addEditButton('createDatabase', Trans::_('create_database'), 'fas fa-database', 'success', 'left', 'action');
            } else {
                $this->addEditButton('runMigrations', Trans::_('go_migrations'), 'fas fa-sync', 'success', 'left', 'action');
            }
            $this->addEditButton('regenerate', Trans::_('regenerate'), 'fas fa-redo', 'warning', 'right', 'action');
            $this->addEditButton('exit', Trans::_('exit'), 'fas fa-sign-out-alt', 'danger', 'right', 'action');
        }
    }

    protected function getEditFields(): array
    {
        $this->languages = Trans::getAvailableLanguages();
        $this->themes = Functions::getThemes();
        $this->dbtypes = Database::getDbDrivers();

        return [
            'miscellaneous' => [
                new Select('main.theme', Trans::_('theme'), $this->themes),
                new Select('main.language', Trans::_('language'), $this->languages),
                new Boolean('security.debug', Trans::_('use_debugbar')),
            ],
            'connection' => [
                new Select('db.type', Trans::_('db_type'), $this->dbtypes, ['readonly' => $this->pdo_connection]),
                new Text('db.host', Trans::_('db_host'), ['readonly' => $this->pdo_connection]),
                new Text('db.user', Trans::_('db_user'), ['readonly' => $this->pdo_connection]),
                new Text('db.pass', Trans::_('db_password'), ['type' => 'password', 'readonly' => $this->pdo_connection]),
            ],
            'database_preferences' => [
                new Text('db.prefix', 'DB Prefix'),
                new Text('db.charset', 'charset'),
                new Text('db.collation', 'collation'),
            ],
            'database' => [
                new Text('db.name', Trans::_('db_name')),
                new Text('db.port', Trans::_('db_port'), ['type' => 'number']),
            ]
        ];
    }

    protected function detectMode()
    {
        // Config is always in Edit Mode
        $this->mode = self::MODE_EDIT;
        $this->recordId = 'current';
    }

    protected function handleRequest()
    {
        $this->checkDatabaseStatus();
        
        if (isset($_GET['ajax'])) {
            if ($_GET['ajax'] === 'get_record') {
                $this->jsonResponse($this->fetchRecordData());
                exit;
            }
            if ($_GET['ajax'] === 'save_record' || (isset($_POST['action']) && $_POST['action'] === 'save')) {
                $this->saveRecord();
                exit;
            }
            if (isset($_POST['action'])) {
                $method = 'do' . ucfirst($_POST['action']);
                if (method_exists($this, $method)) {
                    $this->$method();
                    exit;
                }
            }
        }

        parent::handleRequest();
    }

    protected function fetchRecordData(): array
    {
        $config = Config::getConfig(true);
        // Flatten or nested? ResourceController's saveRecord expects flat keys if they match property names.
        // But for Config, we might want to keep the structure.
        
        return [
            'id' => 'current',
            'data' => $config,
            'meta' => [
                'model' => 'Config'
            ]
        ];
    }

    protected function saveRecord()
    {
        $data = $_POST['data'] ?? [];
        if (empty($data)) {
            $this->jsonResponse(['error' => 'No data provided']);
            exit;
        }

        // Config::setConfig expects a stdClass with main, db, security sections.
        // If data is coming as 'main.theme', we need to unflatten it.
        $configData = Config::getConfig(true) ?? new stdClass();
        foreach ($data as $key => $value) {
            if (str_contains($key, '.')) {
                [$section, $prop] = explode('.', $key, 2);
                if (!isset($configData->$section)) {
                    $configData->$section = new stdClass();
                }
                $configData->$section->$prop = $value;
            }
        }

        if (Config::setConfig($configData) && Config::saveConfig()) {
            $this->jsonResponse([
                'status' => 'success',
                'message' => Trans::_('settings_saved_successfully')
            ]);
        } else {
            $this->jsonResponse(['status' => 'error', 'error' => Trans::_('error_saving_settings')]);
        }
    }

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
        $config = Config::getConfig();
        $this->data = $config ?? new stdClass();

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

        if (isset($this->config)) {
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
        Functions::httpRedirect('index.php');
    }

    public function doRegenerate(): bool
    {
        ModuleManager::regenerate();
        return true;
    }

    public function saveConfig(): bool
    {
        $configFilename = Config::getConfigFilename();
        return (bool)file_put_contents($configFilename, json_encode($this->data, JSON_PRETTY_PRINT));
    }
}
