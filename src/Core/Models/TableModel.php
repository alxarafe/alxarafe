<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Models;

use Alxarafe\Base\Table;

/**
 * Class TableModel
 *
 * @package Alxarafe\Models
 */
class TableModel extends Table
{

    /**
     * TableModel constructor.
     *
     * @param bool $create
     */
    public function __construct(bool $create = true)
    {
        parent::__construct(
            'tables', [
                'idField' => 'tablename',
                'nameField' => 'model',
                'create' => $create,
            ]
        );
    }

    /**
     * Return class dependencies
     */
    public function getDependencies()
    {
        return [
            'Alxarafe\\Models\\Page',
        ];
    }
}
