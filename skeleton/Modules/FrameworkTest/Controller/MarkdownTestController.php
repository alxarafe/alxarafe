<?php

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
