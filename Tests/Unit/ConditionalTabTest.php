<?php

declare(strict_types=1);

namespace Tests\Unit;

use Alxarafe\Component\Container\Tab;
use Alxarafe\Component\Fields\Text;
use Alxarafe\Lib\Trans;
use PHPUnit\Framework\TestCase;

/**
 * Test for Mejora 1: Conditional Tab Rendering.
 *
 * Tests the visibility logic directly by simulating what getTabs() does internally.
 */
class ConditionalTabTest extends TestCase
{
    /**
     * Build tabs from editFields applying visibility rules, matching the logic in ResourceTrait::getTabs().
     *
     * @param array $editFields
     * @param array $tabVisibility
     * @return Tab[]
     */
    private function buildTabs(array $editFields, array $tabVisibility = []): array
    {
        $tabs = [];

        foreach ($editFields as $key => $data) {
            // Check tab visibility — same logic as ResourceTrait::getTabs()
            if (isset($tabVisibility[$key]) && is_callable($tabVisibility[$key])) {
                if (!call_user_func($tabVisibility[$key])) {
                    continue;
                }
            }

            if (is_array($data) && isset($data['fields'])) {
                $label = $data['label'] ?? $key;
                $tabs[] = new Tab($key, $label, '', $data['fields']);
            } elseif (is_array($data)) {
                $tabs[] = new Tab($key, $key, '', $data);
            }
        }

        return $tabs;
    }

    public function testAllTabsVisibleByDefault(): void
    {
        $tabs = $this->buildTabs([
            'main'    => ['label' => 'Main',    'fields' => [new Text('name', 'Name')]],
            'address' => ['label' => 'Address', 'fields' => [new Text('city', 'City')]],
            'notes'   => ['label' => 'Notes',   'fields' => [new Text('note', 'Note')]],
        ]);

        $this->assertCount(3, $tabs);
    }

    public function testHiddenTabIsExcluded(): void
    {
        $tabs = $this->buildTabs(
            [
                'main'    => ['label' => 'Main',    'fields' => [new Text('name', 'Name')]],
                'address' => ['label' => 'Address', 'fields' => [new Text('city', 'City')]],
                'notes'   => ['label' => 'Notes',   'fields' => [new Text('note', 'Note')]],
            ],
            [
                'notes' => fn() => false,  // hidden
            ]
        );

        $this->assertCount(2, $tabs);

        $tabIds = array_map(fn(Tab $t) => $t->getTabId(), $tabs);
        $this->assertContains('tab_main', $tabIds);
        $this->assertContains('tab_address', $tabIds);
        $this->assertNotContains('tab_notes', $tabIds);
    }

    public function testDynamicVisibilityCallable(): void
    {
        $showNotes = false;

        $editFields = [
            'main'  => ['label' => 'Main',  'fields' => [new Text('name', 'Name')]],
            'notes' => ['label' => 'Notes', 'fields' => [new Text('note', 'Note')]],
        ];
        $visibility = [
            'notes' => function() use (&$showNotes) { return $showNotes; },
        ];

        // Initially hidden
        $this->assertCount(1, $this->buildTabs($editFields, $visibility));

        // Toggle
        $showNotes = true;
        $this->assertCount(2, $this->buildTabs($editFields, $visibility));
    }

    public function testAllTabsHidden(): void
    {
        $tabs = $this->buildTabs(
            [
                'main'  => ['label' => 'Main',  'fields' => [new Text('x', 'X')]],
                'notes' => ['label' => 'Notes', 'fields' => [new Text('y', 'Y')]],
            ],
            [
                'main'  => fn() => false,
                'notes' => fn() => false,
            ]
        );

        $this->assertCount(0, $tabs);
    }

    public function testNonCallableVisibilityIsIgnored(): void
    {
        // If visibility value is not callable, tab should remain visible
        $tabs = $this->buildTabs(
            [
                'main' => ['label' => 'Main', 'fields' => [new Text('x', 'X')]],
            ],
            [
                'main' => 'not a callable',
            ]
        );

        $this->assertCount(1, $tabs);
    }

    public function testFlatFormatTabsWorkWithVisibility(): void
    {
        $tabs = $this->buildTabs(
            [
                'tab_a' => [new Text('a', 'A')],
                'tab_b' => [new Text('b', 'B')],
            ],
            [
                'tab_a' => fn() => false,
            ]
        );

        $this->assertCount(1, $tabs);
        $this->assertSame('tab_tab_b', $tabs[0]->getTabId());
    }
}
