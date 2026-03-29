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

use Alxarafe\Infrastructure\Service\ApiRouter;
use Modules\Admin\Api\LoginController;
use PHPUnit\Framework\TestCase;

class ApiRouterTest extends TestCase
{
    private ApiRouter $router;

    protected function setUp(): void
    {
        parent::setUp();
        // Clear caches to force a fresh scan of Attributes
        $this->router = new ApiRouter(false);
    }

    public function testLoginRouteIsDiscovered(): void
    {
        $allRoutes = $this->router->getRoutes();
        $route = $this->router->match('POST', '/api/login');
        
        $this->assertNotNull($route, "Login route should be discovered by ApiRouter. Discovered routes: " . print_r($allRoutes, true));
        $this->assertEquals(LoginController::class, $route['class']);
        $this->assertEquals('login', $route['function']);
        $this->assertEmpty($route['roles']);
        $this->assertEmpty($route['permissions']);
    }

    public function testNotFoundReturnsNull(): void
    {
        $route = $this->router->match('GET', '/api/invalid-route');
        $this->assertNull($route);
    }
}
