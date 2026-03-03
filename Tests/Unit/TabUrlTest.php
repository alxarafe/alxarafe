<?php

namespace Tests\Unit;

use Alxarafe\Component\Container\Tab;
use PHPUnit\Framework\TestCase;

class TabUrlTest extends TestCase
{
    public function testTabWithoutUrlReturnsNull(): void
    {
        $tab = new Tab('general', 'General', 'fas fa-cog');
        $this->assertNull($tab->getUrl());
    }

    public function testTabWithUrlReturnsUrl(): void
    {
        $url = '/index.php?module=CRM&controller=Contact&fk_soc=123';
        $tab = new Tab('contacts', 'Contactos', 'fas fa-users', [], [], $url);
        $this->assertSame($url, $tab->getUrl());
    }

    public function testTabConstructorBackwardCompatible(): void
    {
        // Existing 3-arg constructor still works
        $tab1 = new Tab('a', 'A');
        $this->assertNull($tab1->getUrl());

        // Existing 5-arg constructor still works
        $tab2 = new Tab('b', 'B', 'fas fa-home', [], ['class' => 'custom']);
        $this->assertNull($tab2->getUrl());
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
