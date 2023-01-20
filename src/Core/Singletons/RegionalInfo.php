<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Singletons;

use DateTime;
use Exception;

/**
 * Class RegionalInfo
 *
 * @author  Rafael San José Tovar <info@rsanjoseo.com>
 *
 * @package Alxarafe\Core\Singletons
 */
abstract class RegionalInfo
{
    /**
     * Contiene la información regional obtenida del fichero de configuración,
     * o en su defecto, los valores por defecto de la aplicación.
     *
     * @var array
     */
    public static array $config;

    /**
     * Carga los datos de configuración regional en $config
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     */
    public static function load()
    {
        $default = self::getDefaultValues();
        $config = Config::getModuleVar('RegionalInfo');
        foreach ($default as $var => $value) {
            self::$config[$var] = $config[$var] ?? $value;
        }
    }

    /**
     * Obtiene los valores por defecto para las variables regionales
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @return string[]
     */
    private static function getDefaultValues(): array
    {
        return [
            'dateFormat' => 'Y-m-d',
            'timeFormat' => 'H:i:s',
            'datetimeFormat' => 'Y-m-d H:i:s',
            'timezone' => 'Europe/Madrid',
        ];
    }

    /**
     * Obtiene un listado de formatos de fecha
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @return array
     */
    private static function getDateFormats(): array
    {
        $styles = [
            'Y-m-d',
            'Y-m-j',
            'Y-M-d',
            'Y-M-j',
            'd-m-Y',
            'j-m-Y',
            'd-M-Y',
            'j-M-Y',
            'm-d-Y',
            'm-j-Y',
            'M-d-Y',
            'M-j-Y',
        ];
        return self::fillList($styles);
    }

    /**
     * Retorna un array asociativo de estilos con el texto formateado como valor.
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param $styles
     *
     * @return array
     */
    private static function fillList($styles): array
    {
        $result = [];
        foreach ($styles as $style) {
            $result[$style] = self::getFormatted($style);
        }
        return $result;
    }

    /**
     * Retorna una cadena formateada para un instante dado
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param string $style
     * @param string $time
     *
     * @return false|string
     */
    private static function getFormatted(string $style, string $time = '2011-01-07 09:08:07')
    {
        //        return FormatUtils::getFormatted($style, $time);
        try {
            $time = ($time === '') ? 'now' : $time;
            $date = (new DateTime($time))->format($style);
        } catch (Exception $e) {
            $time = ($time === '') ? 'time()' : $time;
            $date = date($style, strtotime($time));
        }
        return $date;
    }

    /**
     * Retorna distintos formatos de tiempo
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @return array
     */
    private static function getTimeFormats(): array
    {
        $styles = [
            'H:i',
            'H:i:s',
            'h:i A',
            'h:i:s A',
        ];
        return self::fillList($styles);
    }
}
