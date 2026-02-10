<?php

namespace Tests\Feature\Chascarrillo;

use Tests\TestCase;
use Modules\Chascarrillo\Controller\PostController;
use Alxarafe\Base\Testing\HttpResponseException;

class PostControllerTest extends TestCase
{
    public function testItReturnsValidationErrorOnEmptySave()
    {
        $_POST = ['action' => 'save', 'data' => []];

        if (!defined('ALX_TEST_USER')) {
            define('ALX_TEST_USER', 'Tester');
        }

        $controller = new PostController();

        try {
            $reflection = new \ReflectionClass($controller);

            // Need to initialize configuration for validation rules to kick in?
            // saveRecord will validate empty data regardless of config generally
            $configMethod = $reflection->getMethod('buildConfiguration');
            $configMethod->setAccessible(true);
            $configMethod->invoke($controller);

            $method = $reflection->getMethod('saveRecord');
            $method->setAccessible(true);
            $method->invoke($controller);

            $this->fail("Expected HttpResponseException was not thrown");
        } catch (HttpResponseException $e) {
            $response = $e->getResponse();
            $this->assertArrayHasKey('error', $response);
            $this->assertEquals('No data provided', $response['error']);
        }
    }

    public function testItCanSaveAPostViaController()
    {
        $data = [
            'title' => 'My First Post',
            'slug' => 'my-first-post',
            'content' => 'This is the content of my first post.',
            'is_published' => 1,
            'published_at' => '2026-02-10 12:00:00'
        ];
        $_POST = ['data' => $data];

        $controller = new PostController();
        $controller->recordId = 'new';
        $controller->mode = 'edit'; // Ensure edit mode for save

        try {
            $reflection = new \ReflectionClass($controller);

            $configMethod = $reflection->getMethod('buildConfiguration');
            $configMethod->setAccessible(true);
            $configMethod->invoke($controller);

            $method = $reflection->getMethod('saveRecord');
            $method->setAccessible(true);
            $method->invoke($controller);

            $this->fail("Expected HttpResponseException was not thrown (success response)");
        } catch (HttpResponseException $e) {
            $response = $e->getResponse();

            $this->assertArrayHasKey('status', $response);
            $this->assertEquals('success', $response['status'], "Save failed: " . json_encode($response));
            $this->assertArrayHasKey('id', $response);

            // Verify DB
            $this->assertDatabaseHas('posts', [
                'id' => $response['id'],
                'title' => 'My First Post',
                'slug' => 'my-first-post'
            ]);
        }
    }

    protected function assertDatabaseHas($table, array $data)
    {
        $query = \Illuminate\Database\Capsule\Manager::table($table);
        foreach ($data as $key => $value) {
            $query->where($key, $value);
        }
        $this->assertTrue($query->exists(), "Record not found in table $table with data " . json_encode($data));
    }
}
