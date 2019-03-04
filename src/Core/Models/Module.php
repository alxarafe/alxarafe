<?php
/**
 * Alxarafe. Development of PHP applications in a flash!
 * Copyright (C) 2018-2019 Alxarafe <info@alxarafe.com>
 */

namespace Alxarafe\Models;

use Alxarafe\Base\Table;

/**
 * Class Module
 *
 * @property int    $id
 * @property string $name
 * @property string $path
 * @property string $enabled
 * @property string $order
 * @property string $inserted_date
 * @property string $updated_date
 *
 * @package Alxarafe\Models
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
     * @return array
     */
    public function getEnabledModules()
    {
        $list = $this->getAllRecordsBy('enabled', '', '<>', 'enabled ASC');
        $return = [];
        foreach ($list as $module) {
            $return[] = $module;
        }
        return $return;
    }
}
