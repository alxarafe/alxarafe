<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class FrameworkTest extends TestCase
{
    public function testFrameworkIsTestable(): void
    {
        // @phpstan-ignore-next-line
        $this->assertTrue(defined('ALX_TESTING'));
    }
}
