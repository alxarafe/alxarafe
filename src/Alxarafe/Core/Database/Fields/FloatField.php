<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Database\Fields;

class FloatField extends AbstractField
{
    /**
     * AbstractNumericComponent constructor.
     *
     * @param $parameters
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function assignData(array $data)
    {
        parent::assignData($data); // TODO: Change the autogenerated stub

        $unsigned = $this->unsigned === 'yes';
        if ($unsigned) {
            $min = 0;
        } else {
            $min = PHP_FLOAT_MIN;
        }
        $max = PHP_FLOAT_MAX;

        if ($this->min === null) {
            $this->min = $min;
        }

        if ($this->max === null) {
            $this->max = $max;
        }
    }

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

        $float = (float) $value;
        if ($float !== $value) {
            self::$errors[] = $this->trans->trans('error-float-expected', $params);
        }

        if (!isset($float)) {
            $integer = (int) $value;
            if ($integer !== $value) {
                self::$errors[] = $this->trans->trans('error-integer-expected', $params);
            }
        }
        $unsigned = isset($struct['unsigned']) && $struct['unsigned'] === 'yes';
        $min = $struct['min'] ?? null;
        $max = $struct['max'] ?? null;
        if ($unsigned && $value < 0) {
            self::$errors[] = $this->trans->trans('error-negative-unsigned', $params);
        }
        if (isset($min) && $value < $min) {
            $params['%min%'] = $min;
            self::$errors[] = $this->trans->trans('error-less-than-minimum', $params);
        }
        if (isset($max) && $value > $max) {
            $params['%max%'] = $max;
            self::$errors[] = $this->trans->trans('error-greater-than-maximum', $params);
        }

        return (count(self::$errors) === 0);
    }
}
