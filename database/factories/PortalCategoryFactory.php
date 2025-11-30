<?php

namespace Database\Factories;

use App\Models\PortalCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PortalCategoryFactory extends Factory
{
    protected $model = PortalCategory::class;

    public function definition(): array
    {
        return [
            'slug' => fake()->unique()->slug,
            'icon' => 'fas fa-folder',
        ];
    }
}
