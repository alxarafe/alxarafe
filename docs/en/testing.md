# Alxarafe Testing Guide

## Introduction

Automated testing is a fundamental pillar in development with Alxarafe. It not only ensures that the code works as expected but also acts as a safety net allowing for aggressive refactoring and serving as living documentation of the system's behavior.

Alxarafe includes a robust **PHPUnit** configuration integrated with Docker, designed to facilitate both unit tests (models, pure logic) and feature tests (controllers, API).

---

## Testing Environment

### Infrastructure

The testing environment is containerized and relies on the following pillars:

1.  **Docker Container (`alxarafe_php`)**: All tests run inside the PHP container to ensure consistency with the production environment (same extensions, PHP version 8.5+).
2.  **Isolated Database (`alxarafe_test`)**:
    *   When tests start, the system automatically connects to a dedicated database called `alxarafe_test`.
    *   This database is automatically created and migrated if it doesn't exist.
    *   **Important:** Tests are never run against the development or production database.
3.  **Database Transactions**:
    *   Each test is automatically wrapped in a **database transaction** (`beginTransaction` in `setUp`).
    *   Upon test completion, the transaction is rolled back (`rollBack` in `tearDown`).
    *   This ensures that **no data persists** after a test execution, keeping the environment clean for the next one.

### Bootstrapping

The `Tests/bootstrap.php` file (and its class `Tests\Bootstrapper`) is responsible for:
*   Defining the `ALX_TESTING` constant.
*   Loading environment configurations.
*   Initializing the connection to the test database.
*   Executing necessary migrations.

---

## Directory Structure

The project distinguishes between "core" (framework) tests and "application" (skeleton) tests.

*   **`Tests/`**: Contains the base testing infrastructure and unit tests for the Alxarafe framework itself (`src/Core`).
    *   `Tests/TestCase.php`: Base class from which all tests must inherit.
    *   `Tests/Unit/`: Core unit tests.
    *   `Tests/Feature/`: Core integration tests.
*   **`skeleton/Tests/`**: Contains specific tests for the example application or final project.
    *   `skeleton/Tests/Unit/`: Tests for your Models and Classes.
    *   `skeleton/Tests/Feature/`: Tests for your Controllers and APIs.

---

## Creating Tests

All tests must inherit from `Tests\TestCase`. This base class provides transaction utilities and custom assertions.

### 1. Model Tests (Unit)

Unit tests for models verify that business logic and persistence work correctly.

**Example: `skeleton/Tests/Unit/PersonTest.php`**

```php
<?php

namespace Tests\Unit;

use Tests\TestCase;
use Modules\Agenda\Model\Person;

class PersonTest extends TestCase
{
    /**
     * Verifies that a person can be created and saved to DB.
     */
    public function testItCanCreateAPerson()
    {
        // 1. Execution
        $person = Person::create([
            'name' => 'John',
            'lastname' => 'Doe',
            'birth_date' => '1990-01-01',
            'active' => true
        ]);

        // 2. Assertions
        $this->assertNotNull($person->id, 'ID should not be null after creation');
        $this->assertEquals('John', $person->name);
        $this->assertTrue($person->active);

        // 3. Database Verification
        // (Note: This checks within the current transaction)
        $this->assertDatabaseHas('people', [
            'id' => $person->id,
            'name' => 'John'
        ]);
    }
}
```

### 2. API and Controller Tests (Feature)

Testing controllers in Alxarafe has particularities because the framework handles HTTP responses and redirects.

#### Handling Responses (`HttpResponseException`)
In the test environment (`ALX_TESTING`), functions like `httpRedirect` or `jsonResponse` **do not terminate execution** (`die()`). Instead, they throw an `Alxarafe\Base\Testing\HttpResponseException`.
This allows capturing the response and making assertions on it.

#### Simulating Authentication
To test protected controllers without going through the full login process, you can define `ALX_TEST_USER` before instantiating the controller.

**Example: `skeleton/Tests/Feature/PersonControllerTest.php`**

```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use Modules\Agenda\Controller\PersonController;
use Alxarafe\Base\Testing\HttpResponseException;

class PersonControllerTest extends TestCase
{
    /**
     * Expected failure test: Validation.
     */
    public function testItReturnsValidationErrorOnEmptySave()
    {
        // 1. Prepare Environment
        $_POST = ['action' => 'save', 'data' => []]; // Empty data to trigger error
        
        // Simulate authenticated user (if needed)
        if (!defined('ALX_TEST_USER')) define('ALX_TEST_USER', 'Tester');

        $controller = new PersonController();

        try {
            // 2. Execute Protected Method via Reflection
            // (Necessary because saveRecord is protected in ResourceController)
            $reflection = new \ReflectionClass($controller);
            
            // Initialize internal controller configuration
            $configMethod = $reflection->getMethod('buildConfiguration');
            $configMethod->setAccessible(true);
            $configMethod->invoke($controller);

            // Invoke save
            $method = $reflection->getMethod('saveRecord');
            $method->setAccessible(true);
            $method->invoke($controller);

            // If no exception happens, the test fails
            $this->fail("HttpResponseException was expected due to validation");
        } catch (HttpResponseException $e) {
            // 3. Verify Error Response
            $response = $e->getResponse();
            $this->assertArrayHasKey('error', $response);
            $this->assertEquals('No data provided', $response['error']);
        }
    }

    /**
     * Success test: Correct save.
     */
    public function testItCanSaveAPersonViaController()
    {
        // 1. Valid Data
        $_POST = ['data' => [
            'name' => 'Jane',
            'lastname' => 'Smith',
            'active' => 1,
            'birth_date' => '1995-05-05'
        ]];

        $controller = new PersonController();
        $controller->recordId = 'new'; // Simulate creation

        try {
            // ... (Reflection setup similar to above) ...
            $reflection = new \ReflectionClass($controller);
            $configMethod = $reflection->getMethod('buildConfiguration');
            $configMethod->setAccessible(true);
            $configMethod->invoke($controller);

            $method = $reflection->getMethod('saveRecord');
            $method->setAccessible(true);
            $method->invoke($controller);

            $this->fail("JSON success response was expected");
        } catch (HttpResponseException $e) {
            // 2. Verify Success Response
            $response = $e->getResponse();
            
            $this->assertArrayHasKey('status', $response);
            $this->assertEquals('success', $response['status']);
            $this->assertArrayHasKey('id', $response);

            // 3. Verify Persistence in DB
            $this->assertDatabaseHas('people', [
                'id' => $response['id'],
                'name' => 'Jane'
            ]);
        }
    }
}
```

---

## Executing Tests

Tests must **always** be executed from within the Docker container to ensure the environment (PHP, extensions, database) is correct.

### Main Commands

Execute all tests (Unit and Feature):
```bash
docker exec alxarafe_php ./vendor/bin/phpunit
```

Execute only a specific suite:
```bash
docker exec alxarafe_php ./vendor/bin/phpunit --testsuite Unit
docker exec alxarafe_php ./vendor/bin/phpunit --testsuite Feature
```

Execute a specific test file:
```bash
docker exec alxarafe_php ./vendor/bin/phpunit skeleton/Tests/Unit/PersonTest.php
```

### Style Verification (PSR-12)

It is critical to maintain code style in tests. Alxarafe enforces **PSR-12**.
Test method names must be `camelCase` (e.g., `testItDoSomething`), **not** `snake_case`.

To verify style:
```bash
docker exec alxarafe_php ./vendor/bin/phpcs --standard=PSR12 Tests/ skeleton/Tests/
```

If there are automatically correctable errors:
```bash
docker exec alxarafe_php ./vendor/bin/phpcbf --standard=PSR12 Tests/ skeleton/Tests/
```
