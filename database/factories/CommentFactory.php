<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{

    public function definition(): array
    {
        return [
            'body' => fake()->sentence(),
            'author_name' => fake()->firstName(),
            'post_id' => function () {
                return Post::inRandomOrder()->first()->id;
            },
            'created_at' => fake()->dateTime(),
            'updated_at' => fake()->dateTime(),
        ];
    }
}
