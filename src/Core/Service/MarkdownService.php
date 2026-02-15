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
}
