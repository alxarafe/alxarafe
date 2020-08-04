<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

use Alxarafe\Core\Providers\Translator;

class StringComponent extends AbstractEditComponent
{

    public static function test($key, $struct, &$value)
    {
        $trans = Translator::getInstance();
        $params = ['%field%' => $trans->trans($key), '%value%' => $value];

        $maxlen = $struct['maxlength'] ?? null;
        $strlen = strlen($value);
        if (isset($maxlen) && $strlen > $maxlen) {
            $params['%strlen%'] = $strlen;
            $params['%maxlen%'] = $maxlen;
            self::$errors[] = $trans->trans('error-string-too-long', $params);
        }

        return(count(self::$errors)==0);
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