<?php

namespace Tests\Unit;

use App\Models\Comment;
use Tests\TestCase;

class CommentTest extends TestCase
{
    public function test_can_create_comment(): void
    {
        $count = Comment::all()->count();
        Comment::factory()->create();
        $newCount = Comment::all()->count();
        $this->assertGreaterThan($count, $newCount);
    }
}
