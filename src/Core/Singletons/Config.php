<?php
/**
 * Copyright (C) 2022-2023  Rafael San José Tovar   <info@rsanjoseo.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Alxarafe\Core\Singletons;

use Symfony\Component\Yaml\Yaml;

/**
 * Class Config
 *
 * Carga la configuración y da soporte para su mantenimiento, leyéndola o guardándola
 * en un archivo yaml.
 *
 * @author  Rafael San José Tovar <info@rsanjoseo.com>
 *
 * @package Alxarafe\Core\Singletons
 */
abstract class Config
{
    /**
     * Ruta completa del fichero de configuración
     *
     * @var string
     */
    private static string $configFilename;

    /**
     * Contiene un array con el contenido íntegro del archivo de configuración.
     *
     * @var array
     */
    private static array $global;

    /**
     * Carga el fichero de configuración en la variable $global. Las constantes definidas
     * en el mismo, se definen como constantes de php con 'define'.
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @return false|void
     */
    public static function load()
    {
        if (!isset(self::$global)) {
            self::$global = self::loadConfigurationFile();
            if (empty(self::$global)) {
                return false;
            }
        }
        self::defineConstants();
    }

    /**
     * Define todas las constantes de la sección 'constants' del archivo config.yaml
     * La sección constants contiene las constantes en grupos de tipo.
     * TODO: De momento se contempla boolean y el resto.
     *
     * @author  Rafael San José Tovar <info@rsanjoseo.com>
     */
    private static function defineConstants()
    {
        foreach (self::$global['constants'] ?? [] as $type => $types) {
            foreach ($types as $name => $value) {
                switch ($type) {
                    case 'boolean':
                        define($name, in_array(strtolower($value), ['1', 'true']));
                        break;
                    default:
                        define($name, $value);
                }
            }
        }
    }

    /**
     * Carga el fichero de configuración y lo retorna como un array
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @return array
     */
    private static function loadConfigurationFile(): array
    {
        $filename = self::getConfigFileName();
        if (isset($filename) && file_exists($filename)) {
            $yaml = file_get_contents($filename);
            if ($yaml) {
                return YAML::parse($yaml);
            }
        }
        return [];
    }

    /**
     * Retorna el nombre del fichero de configuración comprobando que la carpeta
     * que lo debe de contener existe.
     * Si la carpeta no existe, la crea.
     *
     * @return string|null
     */
    private static function getConfigFileName(): ?string
    {
        if (isset(self::$configFilename)) {
            return self::$configFilename;
        }
        $filename = constant('CONFIGURATION_DIR') . 'config.yaml';
        if (
            file_exists($filename) || is_dir(constant('CONFIGURATION_DIR')) || mkdir(constant('CONFIGURATION_DIR'), 0777, true)) {
            self::$configFilename = $filename;
        }
        return self::$configFilename;
    }

    /**
     * Retorna el valor de una variable del archivo de configuración.
     * Si no existe, retorna null.
     *
     * @param string $module
     * @param string $section
     * @param string $name
     *
     * @return string|null ?string
     */
    public static function getVar(string $module, string $section, string $name): ?string
    {
        return self::$global[$module][$section][$name] ?? null;
    }

    /**
     * Retorna un array con todas las variables de un módulo.
     * Si no existe el módulo, retorna null.
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param string $module
     *
     * @return array|null
     */
    public static function getModuleVar(string $module): ?array
    {
        return self::$global[$module] ?? null;
    }

    /**
     * Return true y the config file exists
     *
     * @return bool
     */
    public static function configFileExists(): bool
    {
        return (file_exists(self::getConfigFileName()));
    }

    /**
     * Stores all the variables in a permanent file so that they can be loaded
     * later with loadConfigFile()
     * Returns true if there is no error when saving the file.
     *
     * @return bool
     */
    public static function saveConfigFile(): bool
    {
        $configFile = self::getConfigFileName();
        if (!isset($configFile)) {
            return false;
        }
        return file_put_contents($configFile, YAML::dump(self::$global, 3)) !== false;
    }

    /**
     * Stores a variable.
     *
     * @param string $module
     * @param string $section
     * @param string $name
     * @param string $value
     */
    public static function setVar(string $module, string $section, string $name, string $value)
    {
        self::$global[$module][$section][$name] = $value;
    }
}
