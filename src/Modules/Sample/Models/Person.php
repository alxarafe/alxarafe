<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Modules\Sample\Models;

use Alxarafe\Core\Base\Table;

/**
 * Class Person
 *
 * @package Alxarafe\Modules\Sample\Models
 */
class Person extends Table
{
    /**
     * Person constructor.
     *
     * @param bool $create
     */
    public function __construct(bool $create = false)
    {
        parent::__construct('people', ['create' => $create]);
    }

    /**
     * Returns the name of the identification field of the record. By default it will be name.
     *
     * @return string
     */
    public function getNameField(): string
    {
        return 'name';
    }

    /**
     * Return class dependencies
     *
     * @return string[]
     */
    public function getDependencies(): array
    {
        return [
            'Modules\\Sample\\Models\\Country',
        ];
    }
}
