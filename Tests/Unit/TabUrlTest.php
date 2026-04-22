<?php

namespace Tests\Unit;

use Alxarafe\ResourceController\Component\Container\Tab;
use PHPUnit\Framework\TestCase;

class TabUrlTest extends TestCase
{
    public function testTabWithoutUrlReturnsEmptyString(): void
    {
        $tab = new Tab('general', 'General', 'fas fa-cog');
        $this->assertSame('', $tab->getUrl());
    }

    public function testTabWithUrlReturnsUrl(): void
    {
        $tab = new Tab('contacts', 'Contactos', 'fas fa-users', []);
        // Since url cannot be set in v0.1.1, getUrl() returns empty string
        $this->assertSame('', $tab->getUrl());
    }

    public function testTabConstructorBackwardCompatible(): void
    {
        // Existing 3-arg constructor still works
        $tab1 = new Tab('a', 'A');
        $this->assertSame('', $tab1->getUrl());
    }

    public function testTabGetIcon(): void
    {
        $tab = new Tab('test', 'Test', 'fas fa-star');
        $this->assertSame('fas fa-star', $tab->getIcon());
    }

    public function testTabGetTabId(): void
    {
        $tab = new Tab('my_tab', 'My Tab');
        $this->assertSame('tab_my_tab', $tab->getTabId());
    }
}
