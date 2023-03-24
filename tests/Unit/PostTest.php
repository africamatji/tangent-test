<?php

namespace Tests\Unit;

use App\Models\Post;
use Tests\TestCase;

class PostTest extends TestCase
{
    public function test_can_create_post(): void
    {
        $count = Post::all()->count();
        Post::factory()->create();
        $newCount = Post::all()->count();
        $this->assertGreaterThan($count, $newCount);
    }
}
