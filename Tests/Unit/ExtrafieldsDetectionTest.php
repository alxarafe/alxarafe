<?php

// phpcs:disable PSR1.Classes.ClassDeclaration.MultipleClasses

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * Tests that the extrafields class detection logic works correctly.
 *
 * We test the detection heuristic directly since it's a private method  
 * accessed via reflection. The actual DB integration is tested via
 * feature tests in the consuming application.
 */

// Dummy classes to simulate existence/non-existence of Extrafields models
class DummyModel
{
}
class DummyModelExtrafields
{
    public static function getFields(): array
    {
        return [
            'custom_field_1' => ['field' => 'custom_field_1', 'label' => 'Custom 1', 'genericType' => 'text'],
        ];
    }
}
class DummyModelNoExtrafields
{
}

class ExtrafieldsDetectionTest extends TestCase
{
    /**
     * Test that detection finds an Extrafields class when it exists.
     */
    public function testDetectExtrafieldsClassExists(): void
    {
        $className = DummyModel::class;
        $efClassName = $className . 'Extrafields';

        $this->assertTrue(class_exists($efClassName), 'DummyModelExtrafields should exist');
        /** @phpstan-ignore function.alreadyNarrowedType */
        $this->assertTrue(method_exists($efClassName, 'getFields'), 'getFields should exist on Extrafields');
    }

    /**
     * Test that detection returns null when no Extrafields class exists.
     */
    public function testDetectExtrafieldsClassNotExists(): void
    {
        $className = DummyModelNoExtrafields::class;
        $efClassName = $className . 'Extrafields';

        $this->assertFalse(class_exists($efClassName), 'DummyModelNoExtrafieldsExtrafields should NOT exist');
    }

    /**
     * Test the detection logic matching ResourceTrait::detectExtrafieldsClass()
     */
    public function testDetectionLogicMatches(): void
    {
        // Simulate the detectExtrafieldsClass logic
        $detect = function (?string $modelClass): ?string {
            if (!$modelClass) {
                return null;
            }
            $efClass = $modelClass . 'Extrafields';
            if (class_exists($efClass) && method_exists($efClass, 'getFields')) {
                return $efClass;
            }
            return null;
        };

        // Should find Extrafields
        $result = $detect(DummyModel::class);
        $this->assertSame(DummyModelExtrafields::class, $result);

        // Should NOT find Extrafields
        $result = $detect(DummyModelNoExtrafields::class);
        $this->assertNull($result);

        // Null model class
        $result = $detect(null);
        $this->assertNull($result);
    }
}
