<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Modules\Sample\Models;

use Alxarafe\Core\Base\Table;

/**
 * Class Country
 *
 * @package Modules\Sample\Models
 */
class Country extends Table
{
    /**
     * Country constructor.
     *
     * @param bool $create
     */
    public function __construct(bool $create = false)
    {
        parent::__construct('countries', ['create' => $create]);
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
            Region::class,
            Subregion::class,
            IntermediateRegion::class,
        ];
    }
}
