<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

use Alxarafe\Core\Providers\Translator;

class BoolComponent extends AbstractEditComponent
{

    public static function test($key, $struct, &$value)
    {
        $trans = Translator::getInstance();
        $params = ['%field%' => $trans->trans($key), '%value%' => $value];

        if (in_array(strtolower($value), ['true', 'yes', '1'])) {
            $value = '1';
        } elseif (in_array(strtolower($value), ['false', 'no', '0'])) {
            $value = '0';
        } else {
            self::$errors[] = $trans->trans('error-boolean-expected', $params);
        }
    }

    /**
     * Return the template path to render this component.
     *
     * @return string
     */
    public function getTemplatePath(): string
    {
        return '@Core/components/checkbox.html';
    }
}