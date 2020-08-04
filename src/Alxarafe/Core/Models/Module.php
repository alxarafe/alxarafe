<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2020 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Core\Models;

use Alxarafe\Core\Base\Table;

/**
 * Class Module
 *
 * @property int    $id
 * @property string $name
 * @property string $path
 * @property string $enabled
 * @property string $inserted_date
 * @property string $updated_date
 *
 * @package Alxarafe\Core\Models
 */
class Module extends Table
{
    /**
     * Module constructor.
     *
     * @param bool $create
     */
    public function __construct(bool $create = true)
    {
        parent::__construct(
            'modules',
            [
                'idField' => 'id',
                'nameField' => 'name',
                'create' => $create,
            ]
        );
    }

    /**
     * Returns an ordered list of enabled modules.
     *
     * @return Module[]
     */
    public function getEnabledModules(): array
    {
        return $this->getAllRecordsBy('enabled', 'NULL', '<>', '`enabled` DESC');
    }


    /**
     * Returns a list of modules.
     *
     * @return Module[]
     */
    public function getAllModules(): array
    {
        return $this->getAllRecords();
    }
}
