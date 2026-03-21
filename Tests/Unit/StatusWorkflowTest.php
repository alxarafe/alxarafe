<?php

declare(strict_types=1);

namespace Tests\Unit;

use Alxarafe\Component\Workflow\StatusTransition;
use Alxarafe\Component\Workflow\StatusWorkflow;
use PHPUnit\Framework\TestCase;

/**
 * Test for Mejora 5: Generic Status Workflow.
 */
class StatusWorkflowTest extends TestCase
{
    private function createSampleWorkflow(): StatusWorkflow
    {
        $wf = new StatusWorkflow();
        $wf->addStatus(0, 'Draft', 'badge bg-secondary');
        $wf->addStatus(1, 'Validated', 'badge bg-primary');
        $wf->addStatus(2, 'Closed', 'badge bg-success');
        $wf->addTransition(0, 1, 'validate', 'document.validate');
        $wf->addTransition(1, 2, 'close');
        $wf->addTransition(1, 0, 'reopen');
        return $wf;
    }

    public function testAddStatusAndGetLabel(): void
    {
        $wf = $this->createSampleWorkflow();
        $this->assertSame('Draft', $wf->getStatusLabel(0));
        $this->assertSame('Validated', $wf->getStatusLabel(1));
        $this->assertSame('Closed', $wf->getStatusLabel(2));
    }

    public function testGetStatusLabelUnknown(): void
    {
        $wf = $this->createSampleWorkflow();
        $this->assertSame('Unknown', $wf->getStatusLabel(99));
    }

    public function testGetStatusCssClass(): void
    {
        $wf = $this->createSampleWorkflow();
        $this->assertSame('badge bg-secondary', $wf->getStatusCssClass(0));
        $this->assertSame('badge bg-primary', $wf->getStatusCssClass(1));
        $this->assertSame('badge bg-success', $wf->getStatusCssClass(2));
    }

    public function testGetStatusCssClassUnknown(): void
    {
        $wf = $this->createSampleWorkflow();
        $this->assertSame('', $wf->getStatusCssClass(99));
    }

    public function testGetStatuses(): void
    {
        $wf = $this->createSampleWorkflow();
        $statuses = $wf->getStatuses();
        $this->assertCount(3, $statuses);
        $this->assertArrayHasKey(0, $statuses);
        $this->assertArrayHasKey(1, $statuses);
        $this->assertArrayHasKey(2, $statuses);
    }

    public function testCanTransitionValid(): void
    {
        $wf = $this->createSampleWorkflow();
        $this->assertTrue($wf->canTransition(0, 1));
        $this->assertTrue($wf->canTransition(1, 2));
        $this->assertTrue($wf->canTransition(1, 0));
    }

    public function testCanTransitionInvalid(): void
    {
        $wf = $this->createSampleWorkflow();
        // No direct transition from Draft(0) to Closed(2)
        $this->assertFalse($wf->canTransition(0, 2));
        // No transition from Closed(2) to anything
        $this->assertFalse($wf->canTransition(2, 0));
        $this->assertFalse($wf->canTransition(2, 1));
    }

    public function testCanTransitionWithPermissionGranted(): void
    {
        $wf = $this->createSampleWorkflow();
        $checker = fn(string $perm) => $perm === 'document.validate';

        $this->assertTrue($wf->canTransition(0, 1, $checker));
    }

    public function testCanTransitionWithPermissionDenied(): void
    {
        $wf = $this->createSampleWorkflow();
        $checker = fn(string $perm) => false; // Deny all

        // 0 → 1 requires 'document.validate' permission
        $this->assertFalse($wf->canTransition(0, 1, $checker));
    }

    public function testCanTransitionWithoutPermission(): void
    {
        $wf = $this->createSampleWorkflow();
        $checker = fn(string $perm) => false;

        // 1 → 2 has no permission requirement, so it should pass
        $this->assertTrue($wf->canTransition(1, 2, $checker));
    }

    public function testGetAvailableTransitions(): void
    {
        $wf = $this->createSampleWorkflow();

        // From Draft: only validate (0 → 1)
        $transitions = $wf->getAvailableTransitions(0);
        $this->assertCount(1, $transitions);
        $this->assertSame('validate', $transitions[0]->action);
        $this->assertSame(1, $transitions[0]->to);

        // From Validated: close (1 → 2) and reopen (1 → 0)
        $transitions = $wf->getAvailableTransitions(1);
        $this->assertCount(2, $transitions);
        $actions = array_map(fn(StatusTransition $t) => $t->action, $transitions);
        $this->assertContains('close', $actions);
        $this->assertContains('reopen', $actions);

        // From Closed: nothing
        $transitions = $wf->getAvailableTransitions(2);
        $this->assertCount(0, $transitions);
    }

    public function testGetAvailableTransitionsWithPermissionChecker(): void
    {
        $wf = $this->createSampleWorkflow();
        // Deny 'document.validate'
        $checker = fn(string $perm) => $perm !== 'document.validate';

        // From Draft: validate requires 'document.validate' which is denied
        $transitions = $wf->getAvailableTransitions(0, $checker);
        $this->assertCount(0, $transitions);

        // From Validated: close has no permission, reopen has no permission → both available
        $transitions = $wf->getAvailableTransitions(1, $checker);
        $this->assertCount(2, $transitions);
    }

    public function testStatusTransitionProperties(): void
    {
        $t = new StatusTransition(0, 1, 'validate', 'doc.validate', 'fas fa-check', 'btn-success');
        $this->assertSame(0, $t->from);
        $this->assertSame(1, $t->to);
        $this->assertSame('validate', $t->action);
        $this->assertSame('doc.validate', $t->permission);
        $this->assertSame('fas fa-check', $t->icon);
        $this->assertSame('btn-success', $t->cssClass);
    }

    public function testStatusTransitionDefaultNulls(): void
    {
        $t = new StatusTransition(0, 1, 'validate');
        $this->assertNull($t->permission);
        $this->assertNull($t->icon);
        $this->assertNull($t->cssClass);
    }

    public function testFluentInterface(): void
    {
        $wf = new StatusWorkflow();
        $result = $wf->addStatus(0, 'Draft');
        $this->assertSame($wf, $result);

        $result = $wf->addTransition(0, 1, 'validate');
        $this->assertSame($wf, $result);
    }
}
