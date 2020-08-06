<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Database\Fields;

class EmailField extends StringField
{

    /**
     * The passed value is verified to meet the necessary requirements for the field.
     * The field name is needed in case you have to show a message, to be able to
     * report what field it is.
     * The value of the field may be returned modified if the test can correct it.
     * Returns true if the value is valid.
     *
     * @param $key
     * @param $value
     *
     * @return bool
     */
    public function test($key, &$value): bool
    {
        $params = ['%field%' => $this->trans->trans($key), '%value%' => $value];

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            self::$errors[] = $this->trans->trans('error-invalid-email', $params);
        }

        return (count(self::$errors) === 0);
    }
}
