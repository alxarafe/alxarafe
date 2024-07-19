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
    public static function getAvailableLanguages()
    {
        $pattern = realpath(constant('BASE_PATH') . '/../vendor/rsanjoseo/alxarafe/src/Lang');
        $files = glob($pattern . '/*.yaml');
        $result = [];
        foreach ($files as $file) {
            $lang = substr($file, 1 + strlen($pattern), -5);
            $result[$lang] = self::_($lang);
        }
        return $result;
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
        self::$translations = [];
        self::$translator->setLocale($lang);
        self::getTranslations($lang);
    }

    private static function getTranslations($lang)
    {
        $main_route = realpath(constant('BASE_PATH') . '/../vendor/rsanjoseo/alxarafe/src');

        $routes = [];
        $routes[] = $main_route . '/Lang';
        if (isset($_GET['module'])) {
            $module = $_GET['module'];
            $routes[] = $main_route . '/Modules/' . $module . '/Lang';
        }

        self::$translator->addLoader('array', new ArrayLoader());
        foreach ($routes as $route) {
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
            Debug::message($filename . ' not found');
            return;
        }

        $translates = Yaml::parseFile($filename);
        if (!is_array($translates)) {
            Debug::message($filename . ' is not a valid YAML file');
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
