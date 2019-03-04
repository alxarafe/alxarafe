<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Models;

use Alxarafe\Core\Base\Table;

/**
 * Class Language
 *
 * @property int    $id
 * @property string $name
 * @property string $language
 * @property string $variant
 *
 * @package Alxarafe\Core\Models
 */
class Language extends Table
{
    /**
     * Language constructor.
     *
     * @param bool $create
     */
    public function __construct(bool $create = false)
    {
        parent::__construct('languages', ['create' => $create]);
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
}
