<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Modules\Sample\Models;

use Alxarafe\Core\Base\Table;

/**
 * Class Region
 *
 * @package Alxarafe\Modules\Sample\Models
 */
class Region extends Table
{
    /**
     * Region constructor.
     *
     * @param bool $create
     */
    public function __construct(bool $create = false)
    {
        parent::__construct('regions', ['create' => $create]);
    }
}
