<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018 Alxarafe <info@alxarafe.com>
 */
namespace Alxarafe\Models;

use Alxarafe\Base\Table;

/**
 * Class Language
 *
 * @package Alxarafe\Models
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