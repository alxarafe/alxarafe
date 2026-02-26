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
 * Tab — a single tab pane within a TabGroup.
 *
 * Contains children (panels, fields, etc.) that render inside the pane.
 *
 * Uses templates/container/tab.blade.php for rendering.
 */
class Tab extends AbstractContainer
{
    protected string $containerTemplate = 'tab';

    protected string $icon;

    /**
     * @param string $id   Unique tab identifier (e.g. 'general')
     * @param string $label Tab button label
     * @param string $icon  FontAwesome icon class (optional)
     * @param array  $children Child components for this tab's content
     * @param array  $options  Additional options
     */
    public function __construct(string $id, string $label, string $icon = '', array $children = [], array $options = [])
    {
        $this->icon = $icon;
        parent::__construct('tab_' . $id, $label, $children, $options);
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function getTabId(): string
    {
        return $this->field; // 'tab_{id}'
    }
}
