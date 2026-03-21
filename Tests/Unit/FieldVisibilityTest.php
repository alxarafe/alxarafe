<?php

declare(strict_types=1);

namespace Tests\Unit;

use Alxarafe\Component\AbstractField;
use Alxarafe\Component\Fields\Text;
use Alxarafe\Component\Container\Panel;
use PHPUnit\Framework\TestCase;

/**
 * Test for Mejora 2: Field-level Module Dependency.
 */
class FieldVisibilityTest extends TestCase
{
    public function testFieldWithoutModuleIsAlwaysVisible(): void
    {
        $field = new Text('name', 'Name');
        $this->assertTrue($field->isVisible());
    }

    public function testFieldWithNonExistentModuleFailsOpen(): void
    {
        // Module 'NonExistent' — MenuManager class won't exist in test env,
        // so isVisible() should fail open and return true.
        $field = new Text('name', 'Name', ['module' => 'NonExistent']);
        $this->assertTrue($field->isVisible());
    }

    public function testFieldWithModuleInNestedOptions(): void
    {
        // When options are auto-wrapped, module ends up in options.options.module
        $field = new Text('name', 'Name', ['module' => 'SomeModule']);
        // Should still be visible (fail-open, no MenuManager)
        $this->assertTrue($field->isVisible());
    }

    public function testFilterChildrenRemovesCorrectly(): void
    {
        $field1 = new Text('visible', 'Visible');
        $field2 = new Text('hidden', 'Hidden');

        $panel = new Panel('Test', [$field1, $field2]);

        // Filter: keep only 'visible'
        $panel->filterChildren(fn($child) =>
            !($child instanceof AbstractField) || $child->getField() === 'visible');

        $children = $panel->getChildren();
        $this->assertCount(1, $children);
        $this->assertSame('visible', $children[0]->getField());
    }

    public function testFilterChildrenPreservesNonFields(): void
    {
        $field = new Text('name', 'Name');
        $subPanel = new Panel('Sub', []);

        $panel = new Panel('Main', [$field, $subPanel]);

        // Filter that removes all AbstractFields but keeps containers
        $panel->filterChildren(fn($child) => $child instanceof Panel);

        $children = $panel->getChildren();
        $this->assertCount(1, $children);
        $this->assertInstanceOf(Panel::class, $children[0]);
    }

    public function testFilterChildrenEmptyResult(): void
    {
        $panel = new Panel('Test', [
            new Text('a', 'A'),
            new Text('b', 'B'),
        ]);

        $panel->filterChildren(fn() => false);
        $this->assertCount(0, $panel->getChildren());
    }
}
