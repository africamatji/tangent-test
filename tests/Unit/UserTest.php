<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_can_create_user(): void
    {
        $count = User::all()->count();
        User::factory()->create();
        $newCount = User::all()->count();
        $this->assertGreaterThan($count, $newCount);
    }
}
