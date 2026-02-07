<?php

namespace Tests\Feature;

use Tests\TestCase;
use Modules\Agenda\Controller\PersonController;
use Alxarafe\Base\Testing\HttpResponseException;

class PersonControllerTest extends TestCase
{
    public function testItReturnsValidationErrorOnEmptySave()
    {
        // Mock POST data
        $_POST = ['action' => 'save', 'data' => []]; // Empty data

        if (!defined('ALX_TEST_USER')) {
            define('ALX_TEST_USER', 'Tester');
        }

        $controller = new PersonController();

        // We expect the controller to throw HttpResponseException with validation errors or error response
        try {
            // We need to simulate the environment state required by saveRecord
            // ResourceController::saveRecord reads php://input or $_POST
            // Since we populated $_POST, it should pick it up.

            // To invoke the logic we can call handleRequest() by setting params
            // But handleRequest is protected. ResourceController typically exposes doIndex?
            // saveRecord is protected.

            // We can use reflection to call protected method, or modify controller to be more testable.
            // Or use the Dispatcher?

            // Let's use Reflection for robust unit testing of the protected method
            $reflection = new \ReflectionClass($controller);



            $method = $reflection->getMethod('saveRecord');
            $method->setAccessible(true);
            $method->invoke($controller);

            $this->fail("Expected HttpResponseException was not thrown");
        } catch (HttpResponseException $e) {
            $response = $e->getResponse();
            // Expecting error because data is empty
            $this->assertArrayHasKey('error', $response);
            $this->assertEquals('No data provided', $response['error']);
        }
    }

    public function testItCanSaveAPersonViaController()
    {
        // Mock POST data with JSON payload structure that ResourceController expects
        $data = [
            'name' => 'Jane',
            'lastname' => 'Smith',
            'active' => 1,
            'birth_date' => '1995-05-05'
        ];
        $_POST = ['data' => $data];

        $controller = new PersonController(); // Simulate creating new record
        $controller->recordId = 'new';

        try {
            $reflection = new \ReflectionClass($controller);

            // Initialize configuration
            $configMethod = $reflection->getMethod('buildConfiguration');
            $configMethod->setAccessible(true);
            $configMethod->invoke($controller);

            $method = $reflection->getMethod('saveRecord');
            $method->setAccessible(true);
            $method->invoke($controller);

            $this->fail("Expected HttpResponseException was not thrown");
        } catch (HttpResponseException $e) {
            $response = $e->getResponse();

            $this->assertArrayHasKey('status', $response);
            $this->assertEquals('success', $response['status']);
            $this->assertArrayHasKey('id', $response);

            // Verify DB
            $this->assertDatabaseHas('people', [
                'id' => $response['id'],
                'name' => 'Jane'
            ]);
        }
    }

    protected function assertDatabaseHas($table, array $data)
    {
        $query = \Illuminate\Database\Capsule\Manager::table($table);
        foreach ($data as $key => $value) {
            $query->where($key, $value);
        }
        $this->assertTrue($query->exists(), "Record not found in table $table");
    }
}
