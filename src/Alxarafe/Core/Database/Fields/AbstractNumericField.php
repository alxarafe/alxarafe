<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Database\Fields;

abstract class AbstractNumericField extends AbstractField
{
    /**
     * TODO: Define
     *
     * @var string
     */
    public $unsigned;
    /**
     * TODO: Define
     *
     * @var string
     */
    public $min;
    /**
     * TODO: Define
     *
     * @var string
     */
    public $max;

    /**
     * AbstractNumericComponent constructor.
     *
     * @param $parameters
     */
    public function __construct()
    {
        parent::__construct();

        $this->addRequiredFields(['unsigned', 'min', 'max']);
    }

    /**
     * Assign values to the attributes.
     *
     * @param array $data
     */
    public function assignData(array $data)
    {
        parent::assignData($data); // TODO: Change the autogenerated stub

        if ($this->unsigned !== 'yes') {
            $this->unsigned = 'no';
        }
    }
}
