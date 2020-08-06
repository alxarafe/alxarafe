<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Database\Fields;

class PasswordField extends StringField
{

    public function test($key, &$value)
    {
        $params = ['%field%' => $this->trans->trans($key), '%value%' => $value];

        // TODO: Check here if is a correct password

        return (count(self::$errors) === 0);
    }
}
