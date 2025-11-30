<?php

namespace Database\Factories;

use App\Models\Membergroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class MembergroupFactory extends Factory
{
    protected $model = Membergroup::class;

    public function definition(): array
    {
        return [
            'group_name' => fake()->unique()->country(),
            'description' => fake()->sentence,
            'online_color' => fake()->unique()->hexColor(),
            'icons' => '1#icon.png',
        ];
    }
}
