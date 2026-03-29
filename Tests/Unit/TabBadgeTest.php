<?php

declare(strict_types=1);

namespace Tests\Unit;

use Alxarafe\Infrastructure\Component\Container\Tab;
use PHPUnit\Framework\TestCase;

/**
 * Test for Mejora 4: Dynamic Badge Counts on Tabs.
 */
class TabBadgeTest extends TestCase
{
    public function testBadgeCountDefaultsToNull(): void
    {
        $tab = new Tab('contacts', 'Contacts');
        $this->assertNull($tab->getBadgeCount());
    }

    public function testSetBadgeCount(): void
    {
        $tab = new Tab('contacts', 'Contacts');
        $result = $tab->setBadgeCount(5);

        $this->assertSame(5, $tab->getBadgeCount());
        $this->assertSame($tab, $result); // Fluent interface
    }

    public function testSetBadgeCountToZero(): void
    {
        $tab = new Tab('items', 'Items');
        $tab->setBadgeCount(0);
        $this->assertSame(0, $tab->getBadgeCount());
    }

    public function testSetBadgeCountToNull(): void
    {
        $tab = new Tab('items', 'Items');
        $tab->setBadgeCount(5);
        $tab->setBadgeCount(null);
        $this->assertNull($tab->getBadgeCount());
    }

    public function testDefaultBadgeClass(): void
    {
        $tab = new Tab('test', 'Test');
        $this->assertSame('badge bg-secondary ms-1', $tab->getBadgeClass());
    }

    public function testSetBadgeClass(): void
    {
        $tab = new Tab('test', 'Test');
        $result = $tab->setBadgeClass('badge bg-primary ms-1');

        $this->assertSame('badge bg-primary ms-1', $tab->getBadgeClass());
        $this->assertSame($tab, $result); // Fluent interface
    }

    public function testBadgeWithExistingTabFeatures(): void
    {
        // Ensure badge doesn't interfere with existing Tab features
        $tab = new Tab('contacts', 'Contacts', 'fas fa-users', [], [], '/some/url');
        $tab->setBadgeCount(42);

        $this->assertSame(42, $tab->getBadgeCount());
        $this->assertSame('fas fa-users', $tab->getIcon());
        $this->assertSame('/some/url', $tab->getUrl());
        $this->assertSame('tab_contacts', $tab->getTabId());
        $this->assertSame('Contacts', $tab->getLabel());
    }
}
