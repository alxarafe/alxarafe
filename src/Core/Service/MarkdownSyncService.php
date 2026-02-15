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

use Exception;

/**
 * Class MarkdownSyncService
 * 
 * Synchronizes a directory of Markdown files with a database model.
 */
class MarkdownSyncService
{
    /**
     * Synchronizes Markdown files from a directory into a model.
     *
     * @param string $directoryPath Path to the folder containing .md files.
     * @param string $modelClass The Eloquent model class to upsert into.
     * @param string $matchKey The field used to match existing records (default: 'slug').
     * @return array Summary of the synchronization process.
     */
    public static function sync(string $directoryPath, string $modelClass, string $matchKey = 'slug'): array
    {
        $summary = [
            'processed' => 0,
            'created' => 0,
            'updated' => 0,
            'failed' => 0,
            'errors' => [],
        ];

        if (!is_dir($directoryPath)) {
            $summary['errors'][] = "Directory not found: " . $directoryPath;
            return $summary;
        }

        if (!class_exists($modelClass)) {
            $summary['errors'][] = "Model class not found: " . $modelClass;
            return $summary;
        }

        $files = glob($directoryPath . '/*.md');

        foreach ($files as $file) {
            try {
                $data = MarkdownService::parse($file);
                $attributes = $data['meta'];
                $attributes['content'] = $data['content'];

                if (!isset($attributes[$matchKey])) {
                    // Try to infer matchKey from filename if missing in meta
                    $attributes[$matchKey] = pathinfo($file, PATHINFO_FILENAME);
                }

                $record = $modelClass::where($matchKey, $attributes[$matchKey])->first();

                if ($record) {
                    $record->update($attributes);
                    $summary['updated']++;
                } else {
                    $modelClass::create($attributes);
                    $summary['created']++;
                }

                $summary['processed']++;
            } catch (Exception $e) {
                $summary['failed']++;
                $summary['errors'][] = "Error processing " . basename($file) . ": " . $e->getMessage();
            }
        }

        return $summary;
    }
}
