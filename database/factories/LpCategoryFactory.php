<?php

namespace Database\Factories;

use App\Models\LpCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LpCategoryFactory extends Factory
{
    protected $model = LpCategory::class;

    public function definition(): array
    {
        return [
            'icon' => 'fas fa-folder',
            'description' => Str::limit($this->faker->paragraph, 250),
        ];
    }
}
