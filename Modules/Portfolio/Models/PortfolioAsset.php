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

namespace Modules\Portfolio\Models;

use Alxarafe\Core\Base\Table;
use DebugBar\DebugBarException;

/**
 * Class PortfolioAssets
 *
 * @package Modules\Portfolio\Models
 */
class PortfolioAsset extends Table
{

    /**
     * User constructor.
     *
     * @throws DebugBarException
     */
    public function __construct(bool $checkStructure = false)
    {
        parent::__construct('portfolio_assets', ['create' => $checkStructure]);
    }

    public function getFields(): array
    {
        return [
            'id' => [
                'label' => 'id',
                'type' => 'int',
                'extra' => 'auto_increment', // It is assumed to be the primary key
            ],
            'ref' => [
                'label' => 'reference',
                'type' => 'varchar',
                'max' => 128,
            ],
            'label' => [
                'label' => 'label',
                'type' => 'varchar',
                'max' => 255,
            ],
            'asset_type' => [
                'label' => 'asset_type',
                'type' => 'int',
            ],
            'active' => [
                'label' => 'Activo',
                'type' => 'boolean',
                'null' => 'YES',
                'default' => 0,
            ],
        ];
    }

    /**
     * TODO: Undocumented
     *
     * @return array
     */
    public function getKeys(): array
    {
        return [
            'ref' => [
                'INDEX' => 'ref',
            ],
            'label' => [
                'INDEX' => 'label',
            ],
        ];
    }

    /**
     * TODO: Undocumented
     *
     * @return array
     */
    public function getDefaultValues(): array
    {
        return [
            [
                'id' => 1,
                'ref' => 'IE00B03HCZ61',
                'label' => 'Vanguard Global Stock Index Fund Investor EUR Accumulation',
                'asset_type' => 1,
                'active' => 1,
            ],
            [
                'id' => 2,
                'ref' => 'IE00B42W3S00',
                'label' => 'Vanguard Global Small-Cap Index Fund Investor EUR Accumulation',
                'asset_type' => 1,
                'active' => 1,
            ],
            [
                'id' => 3,
                'ref' => 'IE0032620787',
                'label' => 'Vanguard U.S. 500 Stock Index Fund Investor EUR Accumulation',
                'asset_type' => 1,
                'active' => 1,
            ],
        ];
    }
}
