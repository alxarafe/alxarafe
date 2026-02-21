<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 */

declare(strict_types=1);

namespace Alxarafe\Service;

use Symfony\Component\Yaml\Yaml;
use Exception;

/**
 * Class MarkdownService
 * 
 * Handles parsing of Markdown files with YAML FrontMatter.
 */
class MarkdownService
{
    /**
     * Parses a Markdown file and extracts metadata and content.
     *
     * @param string $filePath Absolute path to the .md file.
     * @return array Array with 'meta' (array) and 'content' (string).
     * @throws Exception If file is missing or unreadable.
     */
    public static function parse(string $filePath): array
    {
        if (!file_exists($filePath)) {
            throw new Exception("Markdown file not found: " . $filePath);
        }

        $content = file_get_contents($filePath);
        if ($content === false) {
            throw new Exception("Could not read Markdown file: " . $filePath);
        }

        $pattern = '/^---[\s\n\r]+([\s\S]*?)[\s\n\r]+---[\s\n\r]*([\s\S]*)$/m';

        $meta = [];
        $body = $content;

        if (preg_match($pattern, $content, $matches)) {
            $yaml = $matches[1];
            $body = $matches[2];

            try {
                $meta = Yaml::parse($yaml);
            } catch (Exception $e) {
                // Return partial success or log YAML error? 
                // For now, let's treat it as meta-less instead of failing completely.
                error_log("YAML parsing error in {$filePath}: " . $e->getMessage());
            }
        }

        return [
            'meta' => is_array($meta) ? $meta : [],
            'content' => trim($body),
        ];
    }

    /**
     * Renders Markdown content to HTML, including support for custom Alxarafe blocks.
     *
     * @param string|null $content Markdown text.
     * @return string Rendered HTML.
     */
    public static function render(?string $content): string
    {
        if (empty($content)) {
            return '';
        }

        // Support for feature-grid container: :::: feature-grid
        $content = preg_replace_callback('/::::\s+feature-grid(.*?)::::/s', function ($matches) {
            $body = trim($matches[1]);
            return '<div class="feature-grid">' . self::render($body) . '</div>';
        }, $content);

        // Support for feature-card: ::: feature-card icon="fa-..."
        $content = preg_replace_callback('/:::\s+feature-card\s+icon="([^"]+)"(.*?):::/s', function ($matches) {
            $icon = $matches[1];
            $body = trim($matches[2]);

            $html = '<div class="feature-card">';
            $html .= '<div class="feature-icon"><i class="fas ' . $icon . '"></i></div>';
            $html .= '<div class="feature-content">' . (new \Parsedown())->text($body) . '</div>';
            $html .= '</div>';

            return $html;
        }, $content);

        // Support for feature-item: ::: feature-item width="..." order="..."
        $content = preg_replace_callback('/:::\s+feature-item(.*?)\n(.*?):::/s', function ($matches) {
            $attrs = $matches[1];
            $body = trim($matches[2]);

            preg_match('/width="([^"]*)"/', $attrs, $wMatch);
            preg_match('/order="([^"]*)"/', $attrs, $oMatch);

            $width = $wMatch[1] ?? '6';
            $order = $oMatch[1] ?? '';

            $class = "feature-item col-md-{$width}";
            if ($order === 'reverse') {
                $class .= ' order-md-2';
            }

            return '<div class="' . $class . '">' . (new \Parsedown())->text($body) . '</div>';
        }, $content);

        // Support for Quarto/Pandoc style blocks: ::: callout-type
        $content = preg_replace_callback('/:::\s+callout-(\w+)(.*?):::/s', function ($matches) {
            $type = $matches[1];
            $body = trim($matches[2]);

            // Extract title if exists (first line of body)
            $title = '';
            if (str_starts_with($body, '## ')) {
                preg_match('/^##\s+(.*)$/m', $body, $titleMatch);
                $title = $titleMatch[1] ?? '';
                $body = trim(preg_replace('/^##\s+.*$/m', '', $body, 1));
            }

            $icon = match ($type) {
                'info' => 'fas fa-info-circle',
                'warn' => 'fas fa-exclamation-triangle',
                'note' => 'fas fa-sticky-note',
                default => 'fas fa-lightbulb'
            };

            $html = '<div class="callout callout-' . $type . '">';
            if ($title) {
                $html .= '<div class="callout-title"><i class="' . $icon . '"></i> ' . htmlspecialchars($title) . '</div>';
            }
            $html .= (new \Parsedown())->text($body);
            $html .= '</div>';

            return $html;
        }, $content);

        return (new \Parsedown())->text($content);
    }
}
