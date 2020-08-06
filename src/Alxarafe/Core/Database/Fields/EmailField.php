<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Database\Fields;

class EmailField extends StringField
{

    public function test($key, &$value)
    {
        $params = ['%field%' => $this->trans->trans($key), '%value%' => $value];

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            self::$errors[] = $this->trans->trans('error-invalid-email', $params);
        }

        return (count(self::$errors) === 0);
    }
}
