<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Controllers;

use Alxarafe\Core\Base\CacheCore;
use Alxarafe\Core\Base\Controller;
use Alxarafe\Core\Database\Engine;
use Alxarafe\Core\Providers\Config;
use Alxarafe\Core\Providers\Database;
use Alxarafe\Core\Providers\FlashMessages;
use Alxarafe\Core\Providers\ModuleManager;
use Alxarafe\Core\Providers\RegionalInfo;
use Alxarafe\Core\Providers\Translator;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
        switch ($this->request->request->get('action')) {
            case 'save':
                $msg = ($this->save() ? 'changes-stored' : 'changes-not-stored');
                FlashMessages::getInstance()::setSuccess($this->translator->trans($msg));
                return $this->redirect(baseUrl('index.php?call=' . $this->shortName . '&method=generate'));
            case 'cancel':
                return $this->redirect(baseUrl('index.php'));
        }
        CacheCore::getInstance()->getEngine()->clear();
        unset($this->regionalConfig['timezone']);
        return $this->sendResponseTemplate();
    }

    /**
     * Sets default data values
     */
    private function setDefaultData(): void
    {
        $translatorConfig = Translator::getInstance()->getConfig();
        $templateRenderConfig = $this->renderer->getConfig();
        $databaseConfig = Database::getInstance()->getConfig();
        $regionalConfig = RegionalInfo::getInstance()->getConfig();

        $this->dbEngines = Engine::getEngines();
        $this->skins = $this->renderer->getSkins();
        $this->skin = $templateRenderConfig['skin'] ?? $this->skins[0] ?? '';
        $this->languages = Translator::getInstance()->getAvailableLanguages();
        $this->language = $translatorConfig['language'] ?? $this->languages[0] ?? Translator::FALLBACK_LANG;

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
        $translatorConfig['language'] = $this->request->request->get('language', $translatorConfig['language']);
        if (!Translator::getInstance()->setConfig($translatorConfig)) {
            FlashMessages::getInstance()::setError($this->translator->trans('language-data-not-changed'));
            $result = false;
        }

        $templateRenderConfig = $this->renderer->getConfig();
        $templateRenderConfig['skin'] = $this->request->request->get('skin', $templateRenderConfig['skin']);
        if (!$this->renderer->setConfig($templateRenderConfig)) {
            FlashMessages::getInstance()::setError($this->translator->trans('templaterender-data-not-changed'));
            $result = false;
        }

        $regionalConfig = RegionalInfo::getInstance()->getConfig();
        $regionalConfig['timezone'] = $this->request->request->get('timezone', $regionalConfig['timezone']);
        $regionalConfig['dateFormat'] = $this->request->request->get('dateFormat', $regionalConfig['dateFormat']);
        $regionalConfig['timeFormat'] = $this->request->request->get('timeFormat', $regionalConfig['timeFormat']);
        $regionalConfig['datetimeFormat'] = $this->request->request->get('datetimeFormat', $regionalConfig['datetimeFormat']);
        if (!RegionalInfo::getInstance()->setConfig($regionalConfig)) {
            FlashMessages::getInstance()::setError($this->translator->trans('regionalinfo-data-not-changed'));
            $result = false;
        }

        $databaseConfig = Database::getInstance()->getConfig();
        $databaseConfigOrig = $databaseConfig;
        $databaseConfig['dbEngineName'] = $this->request->request->get('dbEngineName', $databaseConfig['dbEngineName']);
        $databaseConfig['dbUser'] = $this->request->request->get('dbUser', $databaseConfig['dbUser']);
        $databaseConfig['dbPass'] = $this->request->request->get('dbPass', $databaseConfig['dbPass']);
        $databaseConfig['dbName'] = $this->request->request->get('dbName', $databaseConfig['dbName']);
        $databaseConfig['dbHost'] = $this->request->request->get('dbHost', $databaseConfig['dbHost']);
        $databaseConfig['dbPrefix'] = $this->request->request->get('dbPrefix', $databaseConfig['dbPrefix']);
        $databaseConfig['dbPort'] = $this->request->request->get('dbPort', $databaseConfig['dbPort']);
        if (!Database::getInstance()->setConfig($databaseConfig)) {
            FlashMessages::getInstance()::setError($this->translator->trans('database-data-not-changed'));
            $result = false;
        }

        if ($result && $databaseConfigOrig !== $databaseConfig) {
            // The database details have been changed and need to be regenerate cache.
            FlashMessages::getInstance()::setSuccess($this->translator->trans('database-data-updated-successfully'));
            CacheCore::getInstance()->getEngine()->clear();
        }

        return $result;
    }

    /**
     * Regenerate some needed data.
     *
     * @return RedirectResponse
     */
    public function generateMethod(): RedirectResponse
    {
        ModuleManager::getInstance()::executePreprocesses();
        return $this->redirect(baseUrl('index.php?call=Login'));
    }

    /**.
     * Returns the page details.
     *
     * @return array
     */
    public function pageDetails(): array
    {
        $details = [
            'title' => 'create-configuration',
            'icon' => '<i class="fas fa-save"></i>',
            'description' => 'create-configuration-description',
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
    public function getTimezoneList(): array
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
