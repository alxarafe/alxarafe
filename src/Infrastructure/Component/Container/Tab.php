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

namespace Alxarafe\Infrastructure\Component\Container;

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
     * Optional external URL for navigation tabs.
     * When set, the tab renders as an <a> link instead of a Bootstrap toggle button.
     */
    protected ?string $url;

    /**
     * @param string      $id       Unique tab identifier (e.g. 'general')
     * @param string      $label    Tab button label
     * @param string      $icon     FontAwesome icon class (optional)
     * @param array       $children Child components for this tab's content
     * @param array       $options  Additional options
     * @param string|null $url      External URL — if set, tab renders as <a> link
     */
    public function __construct(string $id, string $label, string $icon = '', array $children = [], array $options = [], ?string $url = null)
    {
        $this->icon = $icon;
        $this->url = $url;
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

    /**
     * Get the external URL for this tab, if any.
     *
     * @return string|null URL string or null for inline tab content
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    // --- Badge Support ---

    private ?int $badgeCount = null;
    private string $badgeClass = 'badge bg-secondary ms-1';

    public function setBadgeCount(?int $count): self
    {
        $this->badgeCount = $count;
        return $this;
    }

    public function getBadgeCount(): ?int
    {
        return $this->badgeCount;
    }

    public function setBadgeClass(string $class): self
    {
        $this->badgeClass = $class;
        return $this;
    }

    public function getBadgeClass(): string
    {
        return $this->badgeClass;
    }
}
