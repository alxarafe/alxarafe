<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Utils;

use Alxarafe\Core\Singletons\Debug;
use Alxarafe\Database\Schema;

class MathUtils
{
    /**
     * Retorna el número de bytes que son necesarios para almacenar un número que
     * vaya entre $min y $max, considerando si hay o no signo.
     *
     * Téngase en cuenta que min y unsigned son casi excluyentes, pero que unsigned
     * sí que afecta al tamaño máximo positivo.
     *
     * Esta función pretende determinar el tipo de entero necesario. Las
     * inconsistencias (que no son tales), las tendrá que contemplar quién lo invoque.
     *
     * @author Rafael San José Tovar <info@rsanjoseo.com>
     *
     * @param int  $max
     * @param int  $min
     * @param bool $unsigned
     *
     * @return int
     */
    public static function howManyBytes(int $max, int $min = 0, bool $unsigned = Schema::DEFAULT_INTEGER_UNSIGNED): int
    {
        if ($min > $max) {
            Debug::message('Se ha invocado a howManyBytes con el mínimo y máximo cambiados');
            $tmp = $min;
            $min = $max;
            $max = $tmp;
        }

        $bits = log($max + 1, 2);
        if (!$unsigned) {
            $bits++;
        }
        $bytes = ceil($bits / 8);

        if ($min >= 0) {
            return $bytes;
        }

        $bits = log(abs($min), 2);
        $bytesForMin = ceil(($bits + 1) / 8);
        if ($bytesForMin > $bytes) {
            return $bytesForMin;
        }

        return $bytes;
    }

    public static function getMinMax(int $size, $unsigned = true): array
    {
        $bits = 8 * (int) $size;
        $physicalMaxLength = 2 ** $bits;

        /**
         * $minDataLength y $maxDataLength contendrán el mínimo y máximo valor que puede contener el campo.
         */
        $minDataLength = $unsigned ? 0 : -$physicalMaxLength / 2;
        $maxDataLength = ($unsigned ? $physicalMaxLength : $physicalMaxLength / 2) - 1;

        return [
            'min' => $minDataLength,
            'max' => $maxDataLength,
        ];
    }
}
