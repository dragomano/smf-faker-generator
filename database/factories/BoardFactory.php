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

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_cat' => function () {
                return Category::factory()->create()->id;
            },
            'name' => rtrim($this->faker->sentence(rand(2, 6)), '.'),
            'description' => $this->faker->paragraph,
        ];
    }
}
