<?php

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
use DebugBar\DebugBar;
use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Yaml\Yaml;

abstract class Trans
{
    public const FALLBACK_LANG = 'en';

    protected static $translator;

    private static $translations = [];

    /**
     * List of strings without translation, for debugging bar purposes.
     *
     * @var array
     */
    private static $missingStrings = [];

    private static $missingStringsDebug;

    public static function getInstance()
    {
        if (!isset(static::$translator)) {
            static::initialize();
        }
        return static::$translator;
    }

    /**
     * Initializes the translator.
     *
     * @return bool
     */
    private static function initialize()
    {
        if (isset(static::$translator)) {
            return true;
        }

        self::$translator = new Translator(static::FALLBACK_LANG);
        return isset(static::$translator);
    }

    public static function getMissingStrings()
    {
        static::$missingStringsDebug = [];
        $locale = static::$translator->getLocale();
        foreach (static::$missingStrings as $name => $value) {
            if ($value['lang'] === $locale) {
                continue;
            }
            static::$missingStringsDebug[$name] = '(' . $value['lang'] . ') ' . $value['text'];
        }
        return static::$missingStringsDebug;
    }

    /**
     * Return a text in the selected language.
     *
     * @param $message
     * @param array $parameters
     * @param $locale
     * @return mixed
     */
    public static function _($message, array $parameters = [], $locale = null)
    {
        if (!isset(static::$translator)) {
            static::initialize();
        }

        if (!isset($locale)) {
            $locale = static::$translator->getLocale();
        }

        if (empty(static::$translations)) {
            static::$translations = static::getTranslations($locale ?? self::FALLBACK_LANG);
        }

        $params = [];
        foreach ($parameters as $name => $value) {
            $params['%' . $name . '%'] = $value;
        }
        return self::$translator->trans($message, $params, null, $locale);
    }

    private static function getTranslations($lang)
    {
        if (!isset(static::$translator)) {
            static::initialize();
        }

        if (!isset(static::$translations)) {
            $module = $_GET['module'];
            $main_route = realpath(constant('BASE_PATH') . '/../vendor/rsanjoseo/alxarafe/src');
            $routes = [
                $main_route . '/Lang',
                $main_route . '/Modules/' . $module . '/Lang',
            ];

            self::$translator->addLoader('array', new ArrayLoader());
            foreach ($routes as $route) {
                if ($lang !== self::FALLBACK_LANG) {
                    static::loadLang(self::FALLBACK_LANG, $route);
                }
                static::loadLang($lang, $route);
            }

            self::$translator->addResource('array', static::$translations, $lang);
        }
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
            static::loadLang(substr($lang, 0, 2), $folder);
        }

        $filename = $folder . '/' . $lang . '.yaml';
        if (!file_exists($filename)) {
            Debug::message($filename . ' not found');
            return;
        }

        $translates = Yaml::parseFile($filename);
        if (!is_array($translates)) {
            Debug::message($filename . ' is not a valid YAML file');
            return;
        }

        foreach ($translates as $name => $translate) {
            static::$translations[$name] = $translate;
            static::$missingStrings[$name] = [
                'lang' => $lang,
                'text' => $translate
            ];
        }
    }

    /**
     * Return a text in the selected language.
     * Call directly to extra short function _
     *
     * @param $message
     * @param array $parameters
     * @param $domain
     * @param $locale
     * @return mixed
     */
    public static function trans($message, array $parameters = [], $domain = 'messages', $locale = null)
    {
        return static::_($message, $parameters, $locale);
    }

    /**
     * Loads core and module lang files
     *
     * @param $lang
     * @return void
     */
    public static function setLang($lang)
    {
        self::$translator->setLocale($lang);
        self::getTranslations($lang);
    }
}
