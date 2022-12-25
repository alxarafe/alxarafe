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

namespace Modules\Portfolio\Controllers;

use Alxarafe\Core\Base\Controller;
use Alxarafe\Core\Base\View;
use Modules\Portfolio\Models\PortfolioAssets;
use Alxarafe\Views\IndexView;

class Index extends Controller
{
    /**
     *
     * @return View
     * @throws \DebugBar\DebugBarException
     */
    public function setView(): View
    {
        new PortfolioAssets();
        return new IndexView($this);
    }
}