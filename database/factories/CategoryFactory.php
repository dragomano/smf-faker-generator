<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => Str::ucfirst($this->faker->unique()->words(rand(1, 3), true)),
            'description' => '',
        ];
    }
}
