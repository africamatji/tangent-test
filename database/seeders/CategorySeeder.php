<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Symfony\Component\Validator\Constraints\Count;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        Category::factory()->count(1)->create();
    }
}
