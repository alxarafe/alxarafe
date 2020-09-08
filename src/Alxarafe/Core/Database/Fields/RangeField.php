<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Database\Fields;

class RangeField extends AbstractField
{

    /**
     * TODO IMPORTANT! We have to check that the test method is correct for this field.
     *
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

        if (in_array(strtolower($value), ['true', 'yes', '1'])) {
            $value = '1';
            return true;
        } elseif (in_array(strtolower($value), ['false', 'no', '0'])) {
            $value = '0';
            return true;
        } else {
            self::$errors[] = $this->trans->trans('error-boolean-expected', $params);
        }
        return false;
    }
}
