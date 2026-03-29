<?php

declare(strict_types=1);

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

namespace Skeleton\Tests\Unit;

use Alxarafe\Infrastructure\Service\ApiDispatcher;
use Alxarafe\Infrastructure\Service\ApiRouter;
use Alxarafe\Infrastructure\Service\ApiException;
use PHPUnit\Framework\TestCase;

class ApiDispatcherTest extends TestCase
{
    private ApiRouter $router;
    private ApiDispatcher $dispatcher;

    protected function setUp(): void
    {
        parent::setUp();
        // Clear caches to force a fresh scan
        $this->router = new ApiRouter(false);
        $this->dispatcher = new ApiDispatcher($this->router);
    }

    public function testAuthenticationAndAuthorizationMethodThrowsErrorOnMissingToken(): void
    {
        // Use reflection to test the private authenticateAndAuthorize method directly for isolation
        $reflection = new \ReflectionClass(ApiDispatcher::class);
        $method = $reflection->getMethod('authenticateAndAuthorize');
        $method->setAccessible(true);

        // Dummy route requiring an admin role
        $fakeRoute = [
            'roles' => ['admin'],
            'permissions' => []
        ];

        // Ensure SERVER variables that might have HTTP auth are empty
        unset($_SERVER['Authorization']);
        unset($_SERVER['HTTP_AUTHORIZATION']);

        $this->expectException(ApiException::class);
        $this->expectExceptionMessageMatches('/Unauthorized/i');
        $this->expectExceptionCode(401);

        $method->invokeArgs($this->dispatcher, [$fakeRoute]);
    }
}
