<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Database\Fields;

class DateField extends AbstractField
{
    public function test($key, &$value)
    {
        $params = ['%field%' => $this->trans->trans($key), '%value%' => $value];

        $default = $struct['default'] ?? null;
        if (isset($default)) {
            if (substr(strtoupper($default), 0, 7) == 'CURRENT') {
                $value = date('Y-m-d');
            }
        }
        if ($value == '') {
            self::$errors[] = $this->trans->trans('date-can-not-be-blank', $params);
        }
        return (count(self::$errors) === 0);
    }
}
