<?php
/**
 * Copyright (C) 2022-2023  Rafael San José Tovar   <info@rsanjoseo.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Alxarafe\Models;

use Alxarafe\Core\Base\Table;

/**
 * Class Module
 *
 * @package Modules\Main\Models
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
