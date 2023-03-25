<?php

namespace Tests\Unit;

use App\Models\Category;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    public function test_can_create_category(): void
    {
        $count = Category::all()->count();
        Category::factory()->create();
        $newCount = Category::all()->count();
        $this->assertGreaterThan($count, $newCount);
    }
}
