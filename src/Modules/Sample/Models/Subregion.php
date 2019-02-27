<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Modules\Sample\Models;

use Alxarafe\Base\Table;

/**
 * Class Subregion
 *
 * @package Alxarafe\Modules\Sample\Models
 */
class Subregion extends Table
{
    /**
     * Subregion constructor.
     *
     * @param bool $create
     */
    public function __construct(bool $create = false)
    {
        parent::__construct('subregions', ['create' => $create]);
    }
}
