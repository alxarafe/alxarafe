<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Controllers;

use Alxarafe\Base\CacheCore;
use Alxarafe\Base\PageController;
use Alxarafe\Database\Engine;
use Alxarafe\PreProcessors;
use Alxarafe\Providers\Database;
use Alxarafe\Providers\FlashMessages;
use Alxarafe\Providers\Translator;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for editing database and skin settings.
 *
 * @package Alxarafe\Controllers
 */
class EditConfig extends PageController
{
    /**
     * List of engines available.
     *
     * @var array
     */
    public $dbEngines;

    /**
     * Engine in use.
     *
     * @var mixed|string
     */
    public $dbEngineName;

    /**
     * List of skins available.
     *
     * @var array
     */
    public $skins;

    /**
     * Skin in use.
     *
     * @var
     */
    public $skin;

    /**
     * List of available languages
     *
     * @var array
     */
    public $languages;

    /**
     * Selected language
     *
     * @var string
     */
    public $language;

    /**
     * Database config values.
     *
     * @var array
     */
    public $dbConfig;

    /**
     * Array that contains the paths to search.
     *
     * @var array
     */
    protected $searchDir;

    /**
     * EditConfig constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->searchDir = [
            'Alxarafe' => constant('ALXARAFE_FOLDER'),
        ];
    }

    /**
     * The start point of the controller.
     *
     * @return Response
     */
    public function indexMethod(): Response
    {
        $this->setDefaultData();
        $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_ENCODED);
        switch ($action) {
            case 'clear-cache':
                CacheCore::getInstance()->getEngine()->clear();
                FlashMessages::getInstance()::setInfo('Cache cleared successfully.');
                break;
            case 'regenerate-data':
                CacheCore::getInstance()->getEngine()->clear();
                FlashMessages::getInstance()::setInfo('Cache cleared successfully.');
                $this->regenerateData();
                break;
            case 'save':
                $msg = ($this->save() ? 'Changes stored' : 'Changes not stored');
                FlashMessages::getInstance()::setInfo($msg);
                break;
            case 'cancel':
                return $this->redirect(baseUrl('index.php'));
        }
        return $this->sendResponseTemplate();
    }

    /**
     * Regenerate some needed data.
     *
     * @return void
     */
    private function regenerateData(): void
    {
        if (!set_time_limit(0)) {
            FlashMessages::getInstance()::setError('cant-increase-time-limit');
        }

        new PreProcessors\Models($this->searchDir);
        new PreProcessors\Pages($this->searchDir);
    }

    /**
     * Save the form changes in the configuration file
     *
     * @return bool
     */
    private function save(): bool
    {
        $result = true;
        $translatorConfig = Translator::getInstance()->getConfig();
        $translatorConfig['language'] = filter_input(INPUT_POST, 'language', FILTER_SANITIZE_ENCODED);
        if (!Translator::getInstance()->setConfig($translatorConfig)) {
            FlashMessages::getInstance()::setError('language-data-not-changed');
            $result = false;
        }

        $templateRenderConfig = $this->renderer->getConfig();
        $templateRenderConfig['skin'] = filter_input(INPUT_POST, 'skin', FILTER_SANITIZE_ENCODED);
        if (!$this->renderer->setConfig($templateRenderConfig)) {
            FlashMessages::getInstance()::setError('templaterender-data-not-changed');
            $result = false;
        }

        $databaseConfig = Database::getInstance()->getConfig();
        $databaseConfigOrig = $databaseConfig;
        $databaseConfig['dbEngineName'] = filter_input(INPUT_POST, 'dbEngineName', FILTER_SANITIZE_ENCODED);
        $databaseConfig['dbUser'] = filter_input(INPUT_POST, 'dbUser', FILTER_SANITIZE_ENCODED);
        $databaseConfig['dbPass'] = filter_input(INPUT_POST, 'dbPass', FILTER_SANITIZE_ENCODED);
        $databaseConfig['dbName'] = filter_input(INPUT_POST, 'dbName', FILTER_SANITIZE_ENCODED);
        $databaseConfig['dbHost'] = filter_input(INPUT_POST, 'dbHost', FILTER_SANITIZE_ENCODED);
        $databaseConfig['dbPrefix'] = filter_input(INPUT_POST, 'dbPrefix', FILTER_SANITIZE_ENCODED);
        $databaseConfig['dbPort'] = filter_input(INPUT_POST, 'dbPort', FILTER_SANITIZE_ENCODED);
        if (!Database::getInstance()->setConfig($databaseConfig)) {
            FlashMessages::getInstance()::setError('database-data-not-changed');
            $result = false;
        }

        if ($result && $databaseConfigOrig !== $databaseConfig) {
            // The database details have been changed and need to be regenerate cache.
            FlashMessages::getInstance()::setSuccess('database-data-updated-successfully');
            CacheCore::getInstance()->getEngine()->clear();
            $this->userAuth->logout();
        }

        return $result;
    }

    /**
     * Sets default data values
     */
    private function setDefaultData()
    {
        $translatorConfig = Translator::getInstance()->getConfig();
        $templateRenderConfig = $this->renderer->getConfig();
        $databaseConfig = Database::getInstance()->getConfig();

        $this->dbEngines = Engine::getEngines();
        $this->skins = $this->renderer->getSkins();
        $this->skin = $templateRenderConfig['skin'] ?? $this->skins[0] ?? '';
        $this->languages = Translator::getInstance()->getAvailableLanguages();
        $this->language = $translatorConfig['language'] ?? $this->languages[0] ?? '';

        $this->dbEngineName = $databaseConfig['dbEngineName'] ?? $this->dbEngines[0] ?? '';
        $this->dbConfig['dbUser'] = $databaseConfig['dbUser'] ?? 'root';
        $this->dbConfig['dbPass'] = $databaseConfig['dbPass'] ?? '';
        $this->dbConfig['dbName'] = $databaseConfig['dbName'] ?? 'alxarafe';
        $this->dbConfig['dbHost'] = $databaseConfig['dbHost'] ?? 'localhost';
        $this->dbConfig['dbPrefix'] = $databaseConfig['dbPrefix'] ?? '';
        $this->dbConfig['dbPort'] = $databaseConfig['dbPort'] ?? '';
    }

    /**
     * Returns the page details.
     *
     * @return array
     */
    public function pageDetails(): array
    {
        $details = [
            'title' => 'edit-configuration',
            'icon' => '<span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>',
            'description' => 'edit-configuration-description',
            //'menu' => 'admin|edit-config',
            'menu' => 'admin',
        ];
        return $details;
    }
}
