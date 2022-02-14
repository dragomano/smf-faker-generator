<?php

namespace Database\Factories;

use App\Models\LpCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LpCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LpCategory::class;

    public function definition(): array
    {
        return [
            'name' => Str::ucfirst($this->faker->unique()->words(rand(1, 3), true)),
            'description' => Str::limit($this->faker->paragraph, 250),
        ];
    }
}
