<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{

    public function definition(): array
    {
        return [
            'title' => fake()->words(3, true),
            'body' => fake()->sentence(),
            'user_id' => function () {
                return User::inRandomOrder()->first()->id;
            },
            'category_id' => Category::first()->id,
            'created_at' => fake()->dateTime(),
            'updated_at' => fake()->dateTime(),
        ];
    }
}
