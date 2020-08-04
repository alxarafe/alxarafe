<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Renders\Twig\Components;

use Alxarafe\Core\Providers\Translator;

class DatetimeComponent extends AbstractEditComponent
{

    public static function test($key, $struct, &$value)
    {
        $trans = Translator::getInstance();
        $params = ['%field%' => $trans->trans($key), '%value%' => $value];

        $default = $struct['default'] ?? null;
        if (isset($default)) {
            if (substr(strtoupper($default), 0, 7) == 'CURRENT') {
                $value = date('Y-m-d H:i:s');
            }
        }
        if ($value == '') {
            self::$errors[] = $trans->trans('date-can-not-be-blank', $params);
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
        return '@Core/components/date.html';
    }
}
