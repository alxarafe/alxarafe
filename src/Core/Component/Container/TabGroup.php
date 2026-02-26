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
 * TabGroup — renders Bootstrap nav-tabs with tab-content panes.
 *
 * Its children MUST be Tab instances.
 * If only one Tab exists, navigation is omitted and content renders directly.
 *
 * Uses templates/container/tab_group.blade.php for rendering.
 */
class TabGroup extends AbstractContainer
{
    protected string $containerTemplate = 'tab_group';

    /**
     * Auto-increment counter for unique group IDs.
     */
    private static int $counter = 0;

    private string $groupId;

    /**
     * @param Tab[] $tabs Array of Tab instances
     * @param array $options Additional options
     */
    public function __construct(array $tabs = [], array $options = [])
    {
        self::$counter++;
        $this->groupId = 'tg_' . self::$counter;

        parent::__construct($this->groupId, '', $tabs, $options);
    }

    public function getGroupId(): string
    {
        return $this->groupId;
    }

    /**
     * @return Tab[]
     */
    public function getTabs(): array
    {
        return array_values(array_filter($this->children, fn($c) => $c instanceof Tab));
    }
}
