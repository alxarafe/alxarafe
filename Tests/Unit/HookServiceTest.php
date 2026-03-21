<?php

declare(strict_types=1);

namespace Tests\Unit;

use Alxarafe\Service\HookService;
use Alxarafe\Service\HookPoints;
use PHPUnit\Framework\TestCase;

/**
 * Test for Mejora 3: Hook System Enhancement.
 */
class HookServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        HookService::clear();
    }

    protected function tearDown(): void
    {
        HookService::clear();
        parent::tearDown();
    }

    // --- filter() ---

    public function testFilterReturnsOriginalValueWhenNoHooks(): void
    {
        $result = HookService::filter('nonexistent.hook', 'original');
        $this->assertSame('original', $result);
    }

    public function testFilterChainsCallbacks(): void
    {
        HookService::add('test.filter', fn($val) => $val . ' first');
        HookService::add('test.filter', fn($val) => $val . ' second');

        $result = HookService::filter('test.filter', 'start');
        $this->assertSame('start first second', $result);
    }

    public function testFilterPassesExtraArgs(): void
    {
        HookService::add('test.filter', fn($val, $multiplier) => $val * $multiplier);

        $result = HookService::filter('test.filter', 5, 3);
        $this->assertSame(15, $result);
    }

    public function testFilterWithArrayValue(): void
    {
        HookService::add('test.fields', function (array $fields) {
            $fields[] = 'extra_field';
            return $fields;
        });

        $result = HookService::filter('test.fields', ['field1', 'field2']);
        $this->assertSame(['field1', 'field2', 'extra_field'], $result);
    }

    // --- resolve() ---

    public function testResolveReplacesPlaceholders(): void
    {
        $result = HookService::resolve('form.{entity}.fields.after', ['entity' => 'ThirdParty']);
        $this->assertSame('form.ThirdParty.fields.after', $result);
    }

    public function testResolveMultiplePlaceholders(): void
    {
        $result = HookService::resolve('form.{entity}.tab.{tab}', ['entity' => 'Order', 'tab' => 'notes']);
        $this->assertSame('form.Order.tab.notes', $result);
    }

    public function testResolveWithHookPointsConstants(): void
    {
        $result = HookService::resolve(HookPoints::BEFORE_SAVE, ['entity' => 'Invoice']);
        $this->assertSame('action.Invoice.before_save', $result);
    }

    public function testResolvePreservesUnmatchedPlaceholders(): void
    {
        $result = HookService::resolve('form.{entity}.{unknown}', ['entity' => 'Test']);
        $this->assertSame('form.Test.{unknown}', $result);
    }

    // --- add() priority ---

    public function testAddSortsByPriority(): void
    {
        $order = [];

        HookService::add('test.prio', function () use (&$order) { $order[] = 'low'; }, 20);
        HookService::add('test.prio', function () use (&$order) { $order[] = 'high'; }, 1);
        HookService::add('test.prio', function () use (&$order) { $order[] = 'med'; }, 10);

        HookService::execute('test.prio');

        $this->assertSame(['high', 'med', 'low'], $order);
    }

    // --- execute() ---

    public function testExecuteReturnsAllResults(): void
    {
        HookService::add('test.exec', fn() => 'a');
        HookService::add('test.exec', fn() => 'b');

        $results = HookService::execute('test.exec');
        $this->assertSame(['a', 'b'], $results);
    }

    public function testExecuteReturnsEmptyForUnknownHook(): void
    {
        $results = HookService::execute('unknown.hook');
        $this->assertSame([], $results);
    }

    // --- render() ---

    public function testRenderConcatenatesStrings(): void
    {
        HookService::add('test.ui', fn() => '<div>A</div>');
        HookService::add('test.ui', fn() => '<div>B</div>');

        $html = HookService::render('test.ui');
        $this->assertSame('<div>A</div><div>B</div>', $html);
    }

    // --- clear() ---

    public function testClearRemovesAllHooks(): void
    {
        HookService::add('test.clear', fn() => 'yes');
        $this->assertSame(['yes'], HookService::execute('test.clear'));

        HookService::clear();
        $this->assertSame([], HookService::execute('test.clear'));
    }
}
