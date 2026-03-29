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

namespace Alxarafe\Domain\Port\Driven;

use Psr\Log\LoggerInterface;

/**
 * LoggerPort — Secondary (driven) port for application logging.
 *
 * Extends PSR-3 LoggerInterface for full compatibility with the
 * PHP logging ecosystem (Monolog, etc.). Any PSR-3 compliant logger
 * can be used as an adapter without writing a wrapper.
 *
 * @package Alxarafe\Domain\Port\Driven
 */
interface LoggerPort extends LoggerInterface
{
    // Inherits all PSR-3 methods:
    // emergency(), alert(), critical(), error(), warning(), notice(), info(), debug(), log()
    //
    // No additional methods needed — PSR-3 is comprehensive.
    // This interface exists to:
    // 1. Provide a domain-specific name in Alxarafe's port vocabulary.
    // 2. Allow future extension if needed without breaking PSR-3 compatibility.
}
