<?php
/**
 * Copyright (C) 2021-2021  Rafael San José Tovar   <info@rsanjoseo.com>
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

namespace Alxarafe\Modules\Portfolio\Controllers;

use Alxarafe\Core\Base\Controller;
use Alxarafe\Core\Base\View;
use Alxarafe\Core\Helpers\Schema;
use Alxarafe\Modules\Portfolio\Models\PortfolioAssets;
use Alxarafe\Modules\Main\Views\IndexView;
use DebugBar\DebugBarException;

class TestTables extends Controller
{
    /**
     * Check structure of table PortfolioAssets.
     *
     * @return View
     * @throws DebugBarException
     */
    public function setView(): View
    {
        $tablename = 'llx_portfolio_assets';
        if (Schema::tableExists($tablename) && !self::$engine->exec("DROP TABLE $tablename")) {
            die("No se ha podido eliminar la tabla llx_portfolio_assets");
        }

        $x = new PortfolioAssets(true);
        return new IndexView($this);
    }
}