<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

namespace Alxarafe\Component\Container;

/**
 * Row — a lightweight layout container that groups children in a Bootstrap row
 * WITHOUT any card/panel visual wrapper.
 *
 * Use Row when you want to place fields side-by-side without the card frame
 * that Panel adds. The Row itself renders just a <div class="row">.
 *
 * Uses templates/container/row.blade.php for rendering.
 */
class Row extends AbstractContainer
{
    protected string $containerTemplate = 'row';

    /**
     * @param array $children Child components (fields or nested containers)
     * @param array $options  Options: 'col' => 'col-12', 'class' => 'g-3 mb-4', etc.
     */
    public function __construct(array $children = [], array $options = [])
    {
        $id = 'row_' . spl_object_id($this);
        parent::__construct($id, '', $children, $options);
    }
}
