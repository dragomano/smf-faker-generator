<?php

namespace Database\Factories;

use App\Models\Board;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BoardFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Board::class;

    public function definition(): array
    {
        return [
            'id_cat' => Category::factory(),
            'name' => rtrim($this->faker->sentence(rand(2, 6)), '.'),
            'description' => $this->faker->paragraph,
        ];
    }
}
