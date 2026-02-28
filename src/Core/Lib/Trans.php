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

/* Copyright (C) 2024      Rafael San José      <rsanjose@alxarafe.com>
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

namespace Alxarafe\Lib;

use Alxarafe\Tools\Debug;
use Alxarafe\Tools\Dispatcher\Dispatcher;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Yaml\Yaml;

abstract class Trans
{
    /**
     * It is the default language when none has been specified yet.
     */
    public const FALLBACK_LANG = 'en';

    private static $translator;

    private static $translations = [];
    private static bool $wasSet = false;

    public static function getAll(): array
    {
        return self::$translations;
    }


    /**
     * List of strings without translation, for debugging bar purposes.
     *
     * @var array
     */
    private static $missingStrings = [];

    private static $missingStringsDebug;

    /**
     * Gets a list of available languages
     *
     * @return array
     */
    /**
     * Gets a list of available languages as [code => native_name].
     * Uses the DB table when available, falls back to YAML file scan.
     *
     * @return array
     */
    public static function getAvailableLanguages(): array
    {
        // Try DB first
        try {
            if (class_exists(\CoreModules\Admin\Model\Language::class)) {
                $model = new \CoreModules\Admin\Model\Language();
                if ($model->existsInSchema()) {
                    return \CoreModules\Admin\Model\Language::getActiveList();
                }
            }
        } catch (\Throwable $e) {
            // DB unavailable — fall through to YAML scan
        }

        return self::getAvailableLanguagesFromYaml();
    }

    /**
     * Gets active languages with flag info as [code => ['name' => ..., 'flag' => ...]].
     * Used by lang_switcher. Falls back to YAML + hardcoded flags.
     *
     * @return array
     */
    public static function getAvailableLanguagesWithFlags(): array
    {
        try {
            if (class_exists(\CoreModules\Admin\Model\Language::class)) {
                $model = new \CoreModules\Admin\Model\Language();
                if ($model->existsInSchema()) {
                    return \CoreModules\Admin\Model\Language::getActiveWithFlags();
                }
            }
        } catch (\Throwable $e) {
            // DB unavailable
        }

        // Fallback: YAML names + hardcoded flags
        $languages = self::getAvailableLanguagesFromYaml();
        $defaultFlags = [
            // Full locale codes (idioma_PAIS)
            'es_ES' => 'es',
            'en_US' => 'us',
            'en_GB' => 'gb',
            'fr_FR' => 'fr',
            'de_DE' => 'de',
            'pt_PT' => 'pt',
            'it_IT' => 'it',
            'ca_ES' => 'es-ct',
            'ar_SA' => 'sa',
            'eu_ES' => 'es-pv',
            'gl_ES' => 'es-ga',
            'hi_IN' => 'in',
            'ja_JP' => 'jp',
            'nl_NL' => 'nl',
            'ru_RU' => 'ru',
            'zh_CN' => 'cn',
            'es_AR' => 'ar',
            'pt_BR' => 'br',
            // Legacy short codes (YAML fallback)
            'es' => 'es',
            'en' => 'us',
            'fr' => 'fr',
            'de' => 'de',
            'pt' => 'pt',
            'it' => 'it',
            'ca' => 'es-ct',
        ];
        $result = [];
        foreach ($languages as $code => $name) {
            $result[$code] = ['code' => $code, 'name' => $name, 'flag' => $defaultFlags[$code] ?? 'un'];
        }
        return $result;
    }

    /**
     * Scans YAML files on disk to find available languages.
     * Used as fallback when DB is not available.
     *
     * @return array
     */
    private static function getAvailableLanguagesFromYaml(): array
    {
        $alxPath = defined('ALX_PATH') ? constant('ALX_PATH') : null;
        $searchPaths = [
            realpath(constant('BASE_PATH') . '/../Lang'),
            realpath($alxPath . '/src/Lang'),
        ];

        $result = [];
        foreach ($searchPaths as $path) {
            if ($path && is_dir($path)) {
                $files = glob($path . '/*.yaml');
                foreach ($files as $file) {
                    $lang = basename($file, '.yaml');
                    if (!isset($result[$lang])) {
                        $result[$lang] = self::getNativeName($file, $lang);
                    }
                }
            }
        }
        asort($result);
        return $result;
    }

    private static function getNativeName(string $filename, string $lang): string
    {
        try {
            $content = Yaml::parseFile($filename);
            return $content[$lang] ?? $lang;
        } catch (\Exception $e) {
            return $lang;
        }
    }



    /**
     * Return a text in the selected language.
     *
     * @param string $message
     * @param array $parameters
     * @param string|null $locale
     * @return string
     */
    public static function _(string $message, array $parameters = [], ?string $locale = null): string
    {
        self::initialize();
        if (!isset($locale)) {
            $locale = self::$translator->getLocale();
        }

        $params = [];
        foreach ($parameters as $name => $value) {
            $params['%' . $name . '%'] = $value;
        }

        if (!isset(self::$translations[$message])) {
            self::$missingStrings[$message] = [
                'lang' => self::FALLBACK_LANG,
                'text' => 'Not defined!',
            ];
        }

        return self::$translator->trans($message, $params, null, $locale);
    }

    /**
     * Return a text in the selected language.
     * Call directly to extra short function _
     *
     * @param $message
     * @param array $parameters
     * @param $locale
     * @return mixed
     */
    public static function trans($message, array $parameters = [], $locale = null)
    {
        return self::_($message, $parameters, $locale);
    }

    /**
     * Initializes the translator.
     *
     * @return bool
     */
    public static function initialize()
    {
        if (isset(self::$translator)) {
            return true;
        }

        self::$translator = new Translator(self::FALLBACK_LANG);
        return isset(self::$translator);
    }

    /**
     * Returns an array with the strings that are not found in your language.
     * Keep in mind that those that do exist in your main language also appear
     * (e.g. it may be in "en", but not in "en_US").
     * Generally, for extended languages, such as "en_US", only texts that
     * change from "en" should be included.
     *
     * @return array
     */
    public static function getMissingStrings(): array
    {
        self::initialize();
        self::$missingStringsDebug = [];
        $locale = self::$translator->getLocale();
        foreach (self::$missingStrings as $name => $value) {
            if ($value['lang'] === $locale) {
                continue;
            }
            self::$missingStringsDebug[$name] = '(' . $value['lang'] . ') ' . $value['text'];
        }
        return self::$missingStringsDebug;
    }

    /**
     * Loads core and module lang files
     *
     * @param $lang
     * @return void
     */
    public static function setLang($lang)
    {
        self::initialize();
        self::$translations = [];
        self::$translator->setLocale($lang);
        self::getTranslations($lang);
        self::$wasSet = true;
    }

    public static function wasSet(): bool
    {
        return self::$wasSet;
    }

    public static function getLocale(): string
    {
        self::initialize();
        return self::$translator->getLocale();
    }

    private static function getTranslations($lang)
    {
        $app_route = defined('APP_PATH') ? constant('APP_PATH') : (constant('BASE_PATH') . '/..');
        $main_route = defined('ALX_PATH') ? (constant('ALX_PATH') . '/src') : (constant('BASE_PATH') . '/../vendor/alxarafe/alxarafe/src');

        $routes = [];
        $routes[] = $main_route;
        $routes[] = $app_route;

        // Load translations from ALL modules found in skeleton/Modules (or app_route/Modules)
        $modulesPath = $app_route . '/Modules';
        if (is_dir($modulesPath)) {
            $dirs = array_filter(glob($modulesPath . '/*'), 'is_dir');
            foreach ($dirs as $dir) {
                $routes[] = $dir;
            }
        }

        // Also check framework modules if any
        $mainModulesPath = $main_route . '/Modules';
        if (is_dir($mainModulesPath)) {
            $dirs = array_filter(glob($mainModulesPath . '/*'), 'is_dir');
            foreach ($dirs as $dir) {
                $routes[] = $dir;
            }
        }


        if (isset($_GET[Dispatcher::MODULE])) {
            $module = $_GET[Dispatcher::MODULE];
            $routes[] = $main_route . '/Modules/' . $module;
            $routes[] = $app_route . '/Modules/' . $module;
        }


        self::$translator->addLoader('array', new ArrayLoader());
        foreach ($routes as $route) {
            $route .= '/Lang';
            $route = realpath($route);
            if ($route === false || !file_exists($route)) {
                continue;
            }
            if ($lang !== self::FALLBACK_LANG) {
                self::loadLang(self::FALLBACK_LANG, $route);
            }
            self::loadLang($lang, $route);
        }

        self::$translator->addResource('array', self::$translations, $lang);
    }

    /**
     * Loads language files for the specified path and language.
     *
     * @param string $lang
     * @param string $folder
     */
    private static function loadLang(string $lang, string $folder): void
    {
        if (strlen($lang) > 2) {
            self::loadLang(substr($lang, 0, 2), $folder);
        }

        $filename = $folder . '/' . $lang . '.yaml';
        if (!file_exists($filename)) {
            Debug::message(self::_('trans_file_not_found', ['file' => $filename]));
            return;
        }

        $translates = Yaml::parseFile($filename);
        if (!is_array($translates)) {
            Debug::message(self::_('trans_invalid_yaml', ['file' => $filename]));
            return;
        }

        foreach ($translates as $name => $translate) {
            self::$translations[$name] = $translate;
            self::$missingStrings[$name] = [
                'lang' => $lang,
                'text' => $translate
            ];
        }
    }
}
