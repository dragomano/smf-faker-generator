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
            'group_name' => $this->faker->unique()->country(),
            'description' => $this->faker->sentence,
            'online_color' => $this->faker->unique()->hexColor(),
            'icons' => '1#icon.png',
        ];
    }
}
