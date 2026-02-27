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

use Alxarafe\Base\Config;
use Alxarafe\Base\Controller\ResourceController;
use Alxarafe\Base\Database;
use Alxarafe\Lib\Functions;
use Alxarafe\Lib\Messages;
use Alxarafe\Lib\Trans;
use Alxarafe\Tools\ModuleManager;
use CoreModules\Admin\Model\Migration;
use stdClass;
use Alxarafe\Component\Fields\Select;
use Alxarafe\Component\Fields\Select2;
use Alxarafe\Component\Fields\Text;
use Alxarafe\Component\Fields\Boolean;

use Alxarafe\Attribute\Menu;

/**
 * Class ConfigController. App settings controller.
 */
#[Menu(
    menu: 'main_menu',
    label: 'Config',
    icon: 'fas fa-cogs',
    order: 99,
    permission: 'Admin.Config.doIndex'
)]
class ConfigController extends ResourceController
{


    /**
     * Array with availables languages
     *
     * @var array
     */
    public $languages;

    /**
     * Array containing the fields configuration for editing
     * @var array
     */
    public array $configFields = [];
    public $themes;
    public $dbtypes;

    public $db_create;
    public bool $pdo_connection = false;
    public bool $pdo_db_exists = false;

    #[\Override]
    protected function getModelClass()
    {
        // Config is not a standard Eloquent Model, but we can treat it specially in handleRequest/fetchRecordData
        return 'Alxarafe\Base\Config';
    }

    /**
     * Build the ViewDescriptor for the Config form.
     * Uses the new body format with Panel components.
     */
    #[\Override]
    public function getViewDescriptor(): array
    {
        $tabs = $this->getTabs();
        $body = new \Alxarafe\Component\Container\TabGroup($tabs, ['id' => 'config-tabs']);

        $buttons = [
            ['label' => Trans::_('save_configuration'), 'icon' => 'fas fa-save', 'type' => 'primary', 'action' => 'submit', 'name' => 'save'],
        ];

        if ($this->pdo_connection) {
            if (!$this->pdo_db_exists) {
                $buttons[] = ['label' => Trans::_('create_database'), 'icon' => 'fas fa-database', 'type' => 'success', 'action' => 'submit', 'name' => 'createDatabase'];
            } else {
                $buttons[] = ['label' => Trans::_('go_migrations'), 'icon' => 'fas fa-sync', 'type' => 'success', 'action' => 'submit', 'name' => 'runMigrations'];
            }
            $buttons[] = ['label' => Trans::_('regenerate'), 'icon' => 'fas fa-redo', 'type' => 'warning', 'action' => 'submit', 'name' => 'regenerate'];
            $buttons[] = ['label' => Trans::_('exit'), 'icon' => 'fas fa-sign-out-alt', 'type' => 'danger', 'action' => 'submit', 'name' => 'exit'];
        }

        return [
            'mode'     => $this->mode ?? 'edit',
            'method'   => 'POST',
            'action'   => '?module=' . static::getModuleName() . '&controller=' . static::getControllerName(),
            'recordId' => 'current',
            'record'   => $this->data ?? new \stdClass(),
            'buttons'  => $buttons,
            'body'     => new \Alxarafe\Component\Container\Panel('', [$body], ['col' => 'col-12']),
        ];
    }

    /**
     * Generates configuration tabs based on groups defined in getEditFields().
     * This method can be overridden or extended by child classes.
     *
     * @return array<\Alxarafe\Component\Container\Tab>
     */
    protected function getTabs(): array
    {
        $fields = $this->getEditFields();
        $tabs = [];

        foreach ($fields as $key => $data) {
            // Support for old flat format or new structured format
            $label = $data['label'] ?? Trans::_($key);
            $groupFields = $data['fields'] ?? $data;

            $tabs[] = new \Alxarafe\Component\Container\Tab($key, $label, '', $groupFields);
        }

        return $tabs;
    }

    /**
     * Config is not a standard Eloquent model — skip table integrity check.
     */
    #[\Override]
    protected function checkTableIntegrity()
    {
        // No-op: Config is an abstract class, not an Eloquent model.
    }

    /**
     * Skip the standard buildConfiguration() since ConfigController
     * doesn't use structConfig for its form — getViewDescriptor() handles everything.
     */
    #[\Override]
    protected function buildConfiguration()
    {
        // No-op: Config form structure is defined in getViewDescriptor().
    }

    #[\Override]
    protected function setup()
    {
        // Buttons are defined in getViewDescriptor() instead of here,
        // because pdo_connection is not set until handleRequest() -> checkDatabaseStatus().
        // getViewDescriptor() runs in renderView(), which executes after handleRequest().
    }

    #[\Override]
    protected function getEditFields(): array
    {
        $this->languages = Trans::getAvailableLanguages();
        $this->themes = Functions::getThemes();
        $this->dbtypes = Database::getDbDrivers();

        // Create Timezone Field with Action
        $timezones = ['' => Trans::_('select_timezone')] + $this->getTimezones();
        $tzField = new Select2('main.timezone', Trans::_('timezone'), $timezones);
        $tzField->addAction(
            'fas fa-location-arrow',
            "const tz = Intl.DateTimeFormat().resolvedOptions().timeZone; if(tz) this.parentNode.querySelector('select').value = tz;",
            Trans::_('detect_timezone'),
            'btn-outline-primary'
        );

        return [
            'miscellaneous' => [
                new Select('main.theme', Trans::_('theme'), $this->themes),
                new Select('main.language', Trans::_('language'), $this->languages),
                $tzField,
                new Boolean('security.debug', Trans::_('use_debugbar')),
            ],
            'connection' => [
                new Select('db.type', Trans::_('db_type'), $this->dbtypes),
                new Text('db.host', Trans::_('db_host')),
                new Text('db.user', Trans::_('db_user')),
                new Text('db.pass', Trans::_('db_password'), ['type' => 'password']),
            ],
            'database_preferences' => [
                new Text('db.prefix', Trans::_('db_prefix')),
                new Text('db.charset', Trans::_('db_charset')),
                new Text('db.collation', Trans::_('db_collation')),
            ],
            'database' => [
                new Text('db.name', Trans::_('db_name')),
                new Text('db.port', Trans::_('db_port'), ['type' => 'number']),
            ]
        ];
    }

    #[\Override]
    protected function detectMode()
    {
        // Config is always in Edit Mode
        $this->mode = self::MODE_EDIT;
        $this->recordId = 'current';
    }

    #[\Override]
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

    #[\Override]
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

    #[\Override]
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
            if (empty($_GET['ajax'])) {
                Functions::httpRedirect($this->url('index', ['method' => 'general']) . '#');
                exit;
            }

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
        return 'Config';
    }

    /**
     * Determine if this controller requires authentication.
     * Use to allow access during installation (when DB/Tables are missing).
     */
    #[\Override]
    protected function shouldEnforceAuth(): bool
    {
        $config = \Alxarafe\Base\Config::getConfig();

        // If no config or no DB connection -> Allow access (return false)
        if (!$config || empty($config->db) || !\Alxarafe\Base\Database::checkIfDatabaseExists($config->db, true)) {
            return false;
        }

        // If DB exists, check for users table
        try {
            $dsn = "{$config->db->type}:host={$config->db->host};dbname={$config->db->name};charset={$config->db->charset}";
            $pdo = new \PDO($dsn, $config->db->user, $config->db->pass);
            $prefix = $config->db->prefix ?? '';
            // Use explicit prepared statement or simple query
            $stmt = $pdo->query("SHOW TABLES LIKE '{$prefix}users'");
            if ($stmt && $stmt->rowCount() === 0) {
                return false;
            }
        } catch (\Exception $e) {
            return false;
        }

        // DB and Tables exist -> Enforce Auth
        return true;
    }

    #[\Override]
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
        } else {
            // Check if tables are missing
            $migrations = Config::getMigrations();
            if (!empty($migrations)) {
                // Ensure Database (Capsule) is initialized before using models
                static::connectDb($this->data->db);
                try {
                    $migrationModel = new Migration();
                    if (!$migrationModel->exists()) {
                        Messages::addAdvice(Trans::_('pending_migrations_advice'));
                    }
                } catch (\Exception $e) {
                    // Table not found or other DB error - assume migrations needed
                    Messages::addAdvice(Trans::_('pending_migrations_advice'));
                }
            }
        }
    }

    /**
     * The 'index' action: Default action
     *
     * @return bool
     */
    /**
     * Handles the save action.
     * 
     * @return bool
     */
    #[\Override]
    public function doSave(): bool
    {
        $this->saveRecord();
        // If saveRecord doesn't exit/redirect (e.g. error), fall back to index
        return $this->doIndex();
    }

    #[\Override]
    public function doIndex(): bool
    {
        $this->addVariable('title', Trans::_('configuration'));

        // Must call privateCore() to trigger the ResourceTrait lifecycle:
        // detectMode → buildConfiguration → setup → handleRequest → renderView
        // renderView() generates and caches the Blade template from getViewDescriptor().
        $this->privateCore();

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

    public function doRunMigrations(): void
    {
        Functions::httpRedirect(MigrationController::url());
    }



    public function doExit(): void
    {
        Functions::httpRedirect('index.php');
    }

    public function doRegenerate(): bool
    {
        $execute = filter_input(INPUT_GET, 'execute');

        if ($execute) {
            try {
                switch ($execute) {
                    case 'autoload':
                        Functions::exec('composer dump-autoload');
                        Messages::addMessage('Autoload regenerated.');
                        break;
                    case 'cache':
                        // Clear blade and resources cache
                        $count = Functions::recursiveRemove(constant('BASE_PATH') . '/../var/cache/blade');
                        $count += Functions::recursiveRemove(constant('BASE_PATH') . '/../var/cache/resources');
                        Messages::addMessage("Cache cleared. Total items removed: $count");
                        break;
                    case 'full':
                        ModuleManager::regenerate();
                        Messages::addMessage('System fully regenerated.');
                        break;
                }
            } catch (\Exception $e) {
                Messages::addError('Error: ' . $e->getMessage());
            }
        }

        $this->addVariable('title', 'System Regeneration');
        $this->setDefaultTemplate('page/regenerate');
        return true;
    }

    private function getTimezones(): array
    {
        $identifiers = \DateTimeZone::listIdentifiers();
        return array_combine($identifiers, $identifiers);
    }

    public function saveConfig(): bool
    {
        $configFilename = Config::getConfigFilename();
        return (bool)file_put_contents($configFilename, json_encode($this->data, JSON_PRETTY_PRINT));
    }
}
