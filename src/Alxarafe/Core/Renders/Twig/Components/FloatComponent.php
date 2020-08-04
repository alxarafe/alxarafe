<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

use Alxarafe\Core\Providers\Translator;

class FloatComponent extends AbstractEditComponent
{

    public static function test($key, $struct, &$value)
    {
        $trans = Translator::getInstance();
        $params = ['%field%' => $trans->trans($key), '%value%' => $value];

        $float = (float) $value;
        if ($float !== $value) {
            self::$errors[] = $trans->trans('error-float-expected', $params);
        }

        if (!isset($float)) {
            $integer = (int) $value;
            if ($integer !== $value) {
                self::$errors[] = $trans->trans('error-integer-expected', $params);
            }
        }
        $unsigned = isset($struct['unsigned']) && $struct['unsigned'] === 'yes';
        $min = $struct['min'] ?? null;
        $max = $struct['max'] ?? null;
        if ($unsigned && $value < 0) {
            self::$errors[] = $trans->trans('error-negative-unsigned', $params);
        }
        if (isset($min) && $value < $min) {
            $params['%min%'] = $min;
            self::$errors[] = $trans->trans('error-less-than-minimum', $params);
        }
        if (isset($max) && $value > $max) {
            $params['%max%'] = $max;
            self::$errors[] = $trans->trans('error-greater-than-maximum', $params);
        }
        
        return (count(self::$errors) == 0);
    }

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/integer.html';
    }
}
