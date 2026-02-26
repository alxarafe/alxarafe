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
 * Panel — renders a Bootstrap card with a header and recursive children.
 *
 * Uses templates/container/panel.blade.php for rendering.
 */
class Panel extends AbstractContainer
{
    protected string $containerTemplate = 'panel';

    /**
     * @param string $title Panel title (shown in card header)
     * @param array $fields Child components (fields or nested containers)
     * @param array $options Options: 'col' => 'col-md-6', 'class' => 'border-primary', etc.
     */
    public function __construct(string $title, array $fields = [], array $options = [])
    {
        $id = 'panel_' . strtolower(preg_replace('/[^a-zA-Z0-9]+/', '_', $title));
        parent::__construct($id, $title, $fields, $options);
    }

    /**
     * Alias: getFields() returns the same as getChildren().
     * Backward-compatible for code referencing Panel fields.
     */
    public function getFields(): array
    {
        return $this->children;
    }
}
