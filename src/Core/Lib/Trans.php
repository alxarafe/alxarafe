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

use Symfony\Component\Translation\Translator;
use Symfony\Component\Translation\Loader\ArrayLoader;
use Symfony\Component\Yaml\Yaml;

abstract class Trans
{
    protected static $translator;

    public static function _($message, array $parameters = [], $locale = null)
    {
        if (!isset(static::$translator)) {
            static::initialize();
        }
        return self::$translator->trans($message, $parameters, null, $locale);
    }

    private static function initialize()
    {
        if (self::$translator === null) {
            self::$translator = new Translator($locale);
            self::$translator->addLoader('array', new ArrayLoader());

            // Cargar todos los archivos YAML del directorio de traducción
            $files = glob($translationDir . '/' . $locale . '/*.yaml');

            foreach ($files as $file) {
                $messages = Yaml::parseFile($file);
                self::$translator->addResource('array', $messages, $locale);
            }
        }
    }

    public static function trans($message, array $parameters = [], $domain = 'messages', $locale = null)
    {
        return static::_($message, $parameters, $locale);
    }

    private static function loadLang($lang, $folder): array
    {
        $result = [];
        if (strlen($lang) > 2) {
            $result = static::loadLang(strpos($lang, 0, 2), $folder);
        }

        return array_merge($result, Yaml::parseFile($folder . $lang . '.yaml'));
    }

    public static function setLang($lang)
    {
        $route =realpath(BASE_PATH.'/../vendor/rsanjoseo/alxarafe/src');
        foreach([$route.'/Lang',$route.'/Modules/Admin'] as $path) {
            dd([$path=>static::loadLang($lang, $path)]);
        }
        die($lang);
    }

}