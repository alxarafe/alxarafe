<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Modules\Sample\Models;

use Alxarafe\Core\Base\Table;

/**
 * Class Subregion
 *
 * @package Modules\Sample\Models
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
