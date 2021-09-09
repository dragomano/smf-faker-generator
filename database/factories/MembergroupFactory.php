<?php

namespace Database\Factories;

use App\Models\Membergroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class MembergroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Membergroup::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'group_name' => $this->faker->unique()->country(),
            'description' => $this->faker->sentence,
            'online_color' => $this->faker->unique()->hexColor(),
            'icons' => '1#icon.png',
        ];
    }
}
