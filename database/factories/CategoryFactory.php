<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => Str::ucfirst(fake()->unique()->words(rand(1, 3), true)),
            'description' => Str::limit(fake()->paragraph, 250),
        ];
    }
}
