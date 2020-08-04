<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Modules\Sample\Models;

use Alxarafe\Core\Base\Table;

/**
 * Class IntermediateRegion
 *
 * @package Modules\Sample\Models
 */
class IntermediateRegion extends Table
{
    /**
     * IntermediateRegion constructor.
     *
     * @param bool $create
     */
    public function __construct(bool $create = false)
    {
        parent::__construct('intermediate_regions', ['create' => $create]);
    }
}
