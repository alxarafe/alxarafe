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

namespace Alxarafe\Application\Service;

use Alxarafe\Domain\Port\Driven\PersistencePort;

/**
 * TransactionalService — Base class for application services requiring transactions.
 *
 * Wraps use case execution within a database transaction via the PersistencePort.
 *
 * Usage:
 *   class TransferFundsService extends TransactionalService {
 *       public function execute(TransferCommand $cmd): void {
 *           $this->executeInTransaction(function() use ($cmd) {
 *               // debit source, credit target ...
 *           });
 *       }
 *   }
 *
 * @package Alxarafe\Application\Service
 */
abstract class TransactionalService
{
    public function __construct(
        protected readonly PersistencePort $persistence
    ) {
    }

    /**
     * Execute a callable within a database transaction.
     *
     * @param callable $operation The operation to execute transactionally.
     *
     * @return mixed The return value of the callable.
     *
     * @throws \Throwable Re-thrown after rollback.
     */
    protected function executeInTransaction(callable $operation): mixed
    {
        return $this->persistence->transactional($operation);
    }
}
