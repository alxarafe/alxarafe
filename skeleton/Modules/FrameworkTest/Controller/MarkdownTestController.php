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

namespace Modules\FrameworkTest\Controller;

use Alxarafe\Base\Controller\GenericPublicController;
use Alxarafe\Attribute\Menu;
use Alxarafe\Service\MarkdownService;

#[Menu(
    menu: 'main_menu',
    label: 'Prueba Markdown',
    icon: 'fab fa-markdown',
    order: 11,
    visibility: 'public'
)]
class MarkdownTestController extends GenericPublicController
{
    public static function getModuleName(): string
    {
        return 'FrameworkTest';
    }

    public static function getControllerName(): string
    {
        return 'MarkdownTest';
    }

    public function doIndex(): bool
    {
        $this->title = 'Markdown Test Page';

        // APP_PATH is defined in public/index.php
        $filePath = APP_PATH . '/data/test_markdown.md';

        try {
            $parsed = MarkdownService::parse($filePath);
            $meta = $parsed['meta'];
            $contentMarkdown = $parsed['content'];
            $contentHtml = MarkdownService::render($contentMarkdown);

            $this->addVariable('meta', $meta);
            $this->addVariable('contentHtml', $contentHtml);
            $this->addVariable('contentRaw', $contentMarkdown);
            $this->addVariable('filePath', $filePath);
        } catch (\Exception $e) {
            $this->addVariable('error', $e->getMessage());
        }

        return true;
    }
}
