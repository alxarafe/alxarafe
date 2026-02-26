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
 * HtmlContent — renders raw HTML (e.g. Markdown output) inside a card.
 *
 * Uses templates/container/html_content.blade.php for rendering.
 */
class HtmlContent extends AbstractContainer
{
    protected string $containerTemplate = 'html_content';

    protected string $html;

    /**
     * @param string $html  The raw HTML content to render
     * @param string $label Card header title (optional)
     * @param array  $options Options: 'col' => 'col-12', etc.
     */
    public function __construct(string $html, string $label = '', array $options = [])
    {
        $this->html = $html;
        $id = 'html_' . substr(md5($html), 0, 8);
        parent::__construct($id, $label, [], $options);
    }

    public function getHtml(): string
    {
        return $this->html;
    }
}
