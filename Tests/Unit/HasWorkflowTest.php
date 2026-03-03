<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

/**
 * Mock model class to test HasWorkflow trait without a database.
 */
class MockWorkflowModel
{
    use \Alxarafe\Base\Model\Trait\HasWorkflow;

    protected array $states = [
        0  => ['label' => 'Borrador', 'transitions' => [1]],
        1  => ['label' => 'Validado', 'transitions' => [2, -1]],
        2  => ['label' => 'Cerrado',  'transitions' => []],
        -1 => ['label' => 'Anulado',  'transitions' => [0]],
    ];

    protected string $stateField = 'fk_statut';

    /** Simulated DB field */
    public int $fk_statut = 0;
}

class HasWorkflowTest extends TestCase
{
    private MockWorkflowModel $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new MockWorkflowModel();
    }

    public function testGetCurrentStateReturnsDefault(): void
    {
        $this->assertSame(0, $this->model->getCurrentState());
    }

    public function testGetCurrentStateLabelReturnsCorrectLabel(): void
    {
        $this->assertSame('Borrador', $this->model->getCurrentStateLabel());
    }

    public function testCanTransitionValidReturnsTrue(): void
    {
        // From 0 (Borrador) -> 1 (Validado) is allowed
        $this->assertTrue($this->model->canTransition(1));
    }

    public function testCanTransitionInvalidReturnsFalse(): void
    {
        // From 0 (Borrador) -> 2 (Cerrado) is NOT allowed
        $this->assertFalse($this->model->canTransition(2));
    }

    public function testCanTransitionToNonExistentStateReturnsFalse(): void
    {
        $this->assertFalse($this->model->canTransition(999));
    }

    public function testTransitionChangesState(): void
    {
        // Transition 0 -> 1
        $result = $this->model->transition(1);
        $this->assertTrue($result);
        $this->assertSame(1, $this->model->getCurrentState());
        $this->assertSame('Validado', $this->model->getCurrentStateLabel());
    }

    public function testTransitionFailsOnInvalid(): void
    {
        // Try invalid 0 -> 2
        $result = $this->model->transition(2);
        $this->assertFalse($result);
        // State should remain unchanged
        $this->assertSame(0, $this->model->getCurrentState());
    }

    public function testGetAvailableTransitions(): void
    {
        // From state 0, only state 1 is available
        $transitions = $this->model->getAvailableTransitions();
        $this->assertCount(1, $transitions);
        $this->assertSame(1, $transitions[0]['id']);
        $this->assertSame('Validado', $transitions[0]['label']);

        // Move to state 1 and check available transitions
        $this->model->transition(1);
        $transitions = $this->model->getAvailableTransitions();
        $this->assertCount(2, $transitions);

        $ids = array_column($transitions, 'id');
        $this->assertContains(2, $ids);
        $this->assertContains(-1, $ids);
    }

    public function testGetAvailableTransitionsFromTerminalState(): void
    {
        // Move to state 2 (Cerrado) which has no transitions
        $this->model->fk_statut = 2;
        $transitions = $this->model->getAvailableTransitions();
        $this->assertCount(0, $transitions);
    }

    public function testChainedTransitions(): void
    {
        // 0 -> 1 -> -1 -> 0
        $this->assertTrue($this->model->transition(1));
        $this->assertTrue($this->model->transition(-1));
        $this->assertSame('Anulado', $this->model->getCurrentStateLabel());
        $this->assertTrue($this->model->transition(0));
        $this->assertSame('Borrador', $this->model->getCurrentStateLabel());
    }

    public function testHasWorkflowReturnsTrue(): void
    {
        $this->assertTrue($this->model->hasWorkflow());
    }

    public function testIsInState(): void
    {
        $this->assertTrue($this->model->isInState(0));
        $this->assertFalse($this->model->isInState(1));
    }

    public function testPermissionCheckerBlocks(): void
    {
        $model = new MockWorkflowModel();
        // Set up a checker that blocks all permissions
        $model->statePermissions = ['0->1' => 'order.validate'];
        $model->setPermissionChecker(fn(string $perm) => false);

        $this->assertFalse($model->canTransition(1));
    }

    public function testPermissionCheckerAllows(): void
    {
        $model = new MockWorkflowModel();
        $model->statePermissions = ['0->1' => 'order.validate'];
        $model->setPermissionChecker(fn(string $perm) => true);

        $this->assertTrue($model->canTransition(1));
    }
}
