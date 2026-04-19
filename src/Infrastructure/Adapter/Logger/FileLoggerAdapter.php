<?php

/*
 * Copyright (C) 2024-2026 Rafael San José <rsanjose@alxarafe.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
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

declare(strict_types=1);

namespace Alxarafe\Infrastructure\Adapter\Logger;

use Alxarafe\Domain\Port\Driven\LoggerPort;
use Psr\Log\LogLevel;

/**
 * FileLoggerAdapter — PSR-3 compatible file-based logger.
 *
 * Writes log entries to a file in a simple, human-readable format.
 * Implements LoggerPort (which extends PSR-3 LoggerInterface).
 *
 * @package Alxarafe\Infrastructure\Adapter\Logger
 */
class FileLoggerAdapter implements LoggerPort
{
    private string $filePath;
    private string $minLevel;

    /**
     * Log level priority (lower = more severe).
     */
    private const LEVEL_PRIORITY = [
        LogLevel::EMERGENCY => 0,
        LogLevel::ALERT     => 1,
        LogLevel::CRITICAL  => 2,
        LogLevel::ERROR     => 3,
        LogLevel::WARNING   => 4,
        LogLevel::NOTICE    => 5,
        LogLevel::INFO      => 6,
        LogLevel::DEBUG     => 7,
    ];

    /**
     * @param string $filePath Path to the log file.
     * @param string $minLevel Minimum log level to write (default: debug = all).
     */
    public function __construct(
        string $filePath,
        string $minLevel = LogLevel::DEBUG
    ) {
        $this->filePath = $filePath;
        $this->minLevel = $minLevel;

        // Ensure directory exists
        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
    }

    /** @inheritDoc */
    #[\Override]
    public function emergency(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::EMERGENCY, $message, $context);
    }

    /** @inheritDoc */
    #[\Override]
    public function alert(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::ALERT, $message, $context);
    }

    /** @inheritDoc */
    #[\Override]
    public function critical(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::CRITICAL, $message, $context);
    }

    /** @inheritDoc */
    #[\Override]
    public function error(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }

    /** @inheritDoc */
    #[\Override]
    public function warning(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    /** @inheritDoc */
    #[\Override]
    public function notice(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::NOTICE, $message, $context);
    }

    /** @inheritDoc */
    #[\Override]
    public function info(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    /** @inheritDoc */
    #[\Override]
    public function debug(string|\Stringable $message, array $context = []): void
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }

    /** @inheritDoc */
    #[\Override]
    public function log($level, string|\Stringable $message, array $context = []): void
    {
        // Filter by minimum level
        $levelPriority = self::LEVEL_PRIORITY[$level] ?? 7;
        $minPriority = self::LEVEL_PRIORITY[$this->minLevel] ?? 7;

        if ($levelPriority > $minPriority) {
            return;
        }

        // Interpolate context into message (PSR-3 spec)
        $interpolated = $this->interpolate((string) $message, $context);

        // Format: [2026-03-29 14:30:00] LEVEL: Message {context}
        $timestamp = date('Y-m-d H:i:s');
        $levelUpper = strtoupper((string) $level);
        $contextStr = !empty($context) ? ' ' . json_encode($context, JSON_UNESCAPED_SLASHES) : '';

        $entry = "[{$timestamp}] {$levelUpper}: {$interpolated}{$contextStr}" . PHP_EOL;

        @file_put_contents($this->filePath, $entry, FILE_APPEND | LOCK_EX);
    }

    /**
     * Interpolate context values into the message (PSR-3 spec §1.2).
     */
    private function interpolate(string $message, array $context): string
    {
        $replace = [];
        foreach ($context as $key => $value) {
            if (is_string($value) || (is_object($value) && method_exists($value, '__toString'))) {
                $replace['{' . $key . '}'] = (string) $value;
            }
        }
        return strtr($message, $replace);
    }
}
