<?php

namespace Tests\Feature;

use PHPUnit\Framework\TestCase;

class FrameworkFeatureTest extends TestCase
{
    public function testFeatureTestsAreEnabled(): void
    {
        // @phpstan-ignore-next-line
        $this->assertTrue(defined('ALX_TESTING'));
    }
}
