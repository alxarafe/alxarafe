<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Controllers;

use Alxarafe\Core\Base\Controller;
use Alxarafe\Core\Database\Engine;
use Alxarafe\Core\Helpers\Utils;
use Alxarafe\Core\Providers\Config;
use Alxarafe\Core\Providers\Database;
use Alxarafe\Core\Providers\FlashMessages;
use Alxarafe\Core\Providers\RegionalInfo;
use Alxarafe\Core\Providers\Translator;
use Symfony\Component\HttpFoundation\Response;

/**
 * Controller for editing database and skin settings.
 *
 * @package Alxarafe\Core\Controllers
 */
class CreateConfig extends Controller
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
     * This installation timezone.
     *
     * @var string
     */
    public $timeZone;

    /**
     * Contains a list of timezones.
     *
     * @var array
     */
    public $timeZones;

    /**
     * Contains regional information configuration.
     *
     * @var array
     */
    public $regionalConfig;

    /**
     * Array that contains the paths to search.
     *
     * @var array
     */
    protected $searchDir;

    /**
     * CreateConfig constructor.
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
        if (Config::getInstance()->configFileExists()) {
            return $this->redirect(baseUrl('index.php?' . constant('CALL_CONTROLLER') . '=Login'));
        }

        $this->setDefaultData();
        $action = $this->request->request->get('action');
        switch ($action) {
            case 'save':
                $msg = ($this->save() ? 'changes-stored' : 'changes-not-stored');
                FlashMessages::getInstance()::setSuccess($this->translator->trans($msg));
                $this->regenerateData();
                return $this->redirect(baseUrl('index.php?call=Login'));
            case 'cancel':
                return $this->redirect(baseUrl('index.php'));
        }
        unset($this->regionalConfig['timezone']);
        return $this->sendResponseTemplate();
    }

    /**
     * Sets default data values
     */
    private function setDefaultData()
    {
        $templateRenderConfig = $this->renderer->getConfig();
        $databaseConfig = Database::getInstance()->getConfig();
        $regionalConfig = RegionalInfo::getInstance()->getConfig();

        $this->dbEngines = Engine::getEngines();
        $this->skins = $this->renderer->getSkins();
        $this->skin = $templateRenderConfig['skin'] ?? $this->skins[0] ?? '';

        $translator = Translator::getInstance();
        $this->languages = $translator->getAvailableLanguages();
        $this->language = Translator::FALLBACK_LANG;

        $this->dbEngineName = $databaseConfig['dbEngineName'] ?? $this->dbEngines[0] ?? '';
        $this->dbConfig['dbUser'] = $databaseConfig['dbUser'] ?? 'root';
        $this->dbConfig['dbPass'] = $databaseConfig['dbPass'] ?? '';
        $this->dbConfig['dbName'] = $databaseConfig['dbName'] ?? 'alxarafe';
        $this->dbConfig['dbHost'] = $databaseConfig['dbHost'] ?? 'localhost';
        $this->dbConfig['dbPrefix'] = $databaseConfig['dbPrefix'] ?? '';
        $this->dbConfig['dbPort'] = $databaseConfig['dbPort'] ?? '';

        $this->timeZone = date_default_timezone_get();
        $this->regionalConfig['timezone'] = $regionalConfig['timezone'] ?? $this->timeZone;
        $this->regionalConfig['dateFormat'] = $regionalConfig['dateFormat'] ?? 'Y-m-d';
        $this->regionalConfig['timeFormat'] = $regionalConfig['timeFormat'] ?? 'H:i:s';
        $this->regionalConfig['datetimeFormat'] = $regionalConfig['datetimeFormat'] ?? $this->regionalConfig['dateFormat'] . ' ' . $this->regionalConfig['timeFormat'];
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
        $translatorConfig['language'] = $this->request->request->get('language');
        if (!Translator::getInstance()->setConfig($translatorConfig)) {
            FlashMessages::getInstance()::setError($this->translator->trans('language-data-not-changed'));
            $result = false;
        }

        $templateRenderConfig = $this->renderer->getConfig();
        $templateRenderConfig['skin'] = $this->request->request->get('skin');
        if (!$this->renderer->setConfig($templateRenderConfig)) {
            FlashMessages::getInstance()::setError($this->translator->trans('templaterender-data-not-changed'));
            $result = false;
        }

        $regionalConfig = RegionalInfo::getInstance()->getConfig();
        $regionalConfig['timezone'] = $this->request->request->get('timezone');
        $regionalConfig['dateFormat'] = $this->request->request->get('dateFormat');
        $regionalConfig['timeFormat'] = $this->request->request->get('timeFormat');
        $regionalConfig['datetimeFormat'] = $this->request->request->get('datetimeFormat');
        if (!RegionalInfo::getInstance()->setConfig($regionalConfig)) {
            FlashMessages::getInstance()::setError($this->translator->trans('regionalinfo-data-not-changed'));
            $result = false;
        }

        $databaseConfig = Database::getInstance()->getConfig();
        $databaseConfigOrig = $databaseConfig;
        $databaseConfig['dbEngineName'] = $this->request->request->get('dbEngineName');
        $databaseConfig['dbUser'] = $this->request->request->get('dbUser');
        $databaseConfig['dbPass'] = $this->request->request->get('dbPass');
        $databaseConfig['dbName'] = $this->request->request->get('dbName');
        $databaseConfig['dbHost'] = $this->request->request->get('dbHost');
        $databaseConfig['dbPrefix'] = $this->request->request->get('dbPrefix');
        $databaseConfig['dbPort'] = $this->request->request->get('dbPort');
        if (!Database::getInstance()->setConfig($databaseConfig)) {
            FlashMessages::getInstance()::setError($this->translator->trans('database-data-not-changed'));
            $result = false;
        }

        if ($result && $databaseConfigOrig !== $databaseConfig) {
            // The database details have been changed and need to be regenerate cache.
            FlashMessages::getInstance()::setSuccess($this->translator->trans('database-data-updated-successfully'));
        }
        return $result;
    }

    /**
     * Regenerate some needed data.
     *
     * @return void
     */
    private function regenerateData(): void
    {
        Utils::executePreprocesses($this->searchDir);
    }

    /**.
     * Returns the page details.
     *
     * @return array
     */
    public function pageDetails(): array
    {
        $details = [
            'title' => 'edit-configuration',
            'icon' => '<i class="fas fa-save"></i>',
            'description' => 'edit-configuration-description',
            //'menu' => 'admin|create-config',
            'menu' => 'admin',
        ];
        return $details;
    }

    /**
     * Returns a list of timezones list with GMT offset
     *
     * @return array
     *
     * @link http://stackoverflow.com/a/9328760
     */
    public function getTimezoneList()
    {
        $zonesArray = [];
        $timestamp = time();
        foreach (timezone_identifiers_list() as $key => $zone) {
            date_default_timezone_set($zone);
            $zonesArray[$key]['zone'] = $zone;
            $zonesArray[$key]['diff_from_GMT'] = 'UTC/GMT ' . date('P', $timestamp);
        }
        return $zonesArray;
    }

}