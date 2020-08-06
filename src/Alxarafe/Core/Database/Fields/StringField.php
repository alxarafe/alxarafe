<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Database\Fields;

class StringField extends AbstractField
{
    /**
     * AbstractNumericComponent constructor.
     *
     * @param $parameters
     */
    public function __construct()
    {
        parent::__construct();

        $this->addRequiredFields(['maxlength']);
    }

    public function assignData(array $data)
    {
        parent::assignData($data); // TODO: Change the autogenerated stub

        if ($this->maxlength === null) {
            $this->maxlength = $this->length ?? constant('DEFAULT_STRING_LENGTH');
        }
    }


    public function test($key, &$value)
    {
        $params = ['%field%' => $this->trans->trans($key), '%value%' => $value];

        $maxlen = $struct['maxlength'] ?? null;
        $strlen = strlen($value);
        if (isset($maxlen) && $strlen > $maxlen) {
            $params['%strlen%'] = $strlen;
            $params['%maxlen%'] = $maxlen;
            self::$errors[] = $this->trans->trans('error-string-too-long', $params);
        }

        return (count(self::$errors) === 0);
    }
}
