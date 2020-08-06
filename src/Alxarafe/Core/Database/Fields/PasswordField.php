<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Database\Fields;

use Alxarafe\Core\Providers\Translator;

class PasswordField extends StringField
{

    public static function test($key, $struct, &$value)
    {
        $trans = Translator::getInstance();
        $params = ['%field%' => $trans->trans($key), '%value%' => $value];

        // TODO: Check here if is a correct password

        return (count(self::$errors) === 0);
    }
}
