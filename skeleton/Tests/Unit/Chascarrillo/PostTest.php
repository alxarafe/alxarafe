<?php

namespace Tests\Unit\Chascarrillo;

use Tests\TestCase;
use Modules\Chascarrillo\Model\Post;

class PostTest extends TestCase
{
    public function testItCanCreateAPost()
    {
        $post = new Post();
        $post->title = 'Test Post';
        $post->slug = 'test-post';
        $post->save();

        $this->assertNotNull($post->id);
        $this->assertEquals('Test Post', $post->title);
        $this->assertDatabaseHas('posts', ['slug' => 'test-post']);
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
