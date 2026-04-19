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

/**
 * NullLoggerAdapter — No-op logger for testing and silent environments.
 *
 * Discards all log output. Useful for unit tests or when logging
 * is not needed but a LoggerPort dependency is required.
 *
 * @package Alxarafe\Infrastructure\Adapter\Logger
 */
class NullLoggerAdapter implements LoggerPort
{
    #[\Override]
    public function emergency(string|\Stringable $message, array $context = []): void
    {
}
    #[\Override]
    public function alert(string|\Stringable $message, array $context = []): void
    {
}
    #[\Override]
    public function critical(string|\Stringable $message, array $context = []): void
    {
}
    #[\Override]
    public function error(string|\Stringable $message, array $context = []): void
    {
}
    #[\Override]
    public function warning(string|\Stringable $message, array $context = []): void
    {
}
    #[\Override]
    public function notice(string|\Stringable $message, array $context = []): void
    {
}
    #[\Override]
    public function info(string|\Stringable $message, array $context = []): void
    {
}
    #[\Override]
    public function debug(string|\Stringable $message, array $context = []): void
    {
}
    #[\Override]
    public function log($level, string|\Stringable $message, array $context = []): void
    {
}
}
