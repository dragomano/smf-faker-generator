<?php

namespace Database\Factories;

use App\Models\PortalTag;
use Illuminate\Database\Eloquent\Factories\Factory;

class PortalTagFactory extends Factory
{
    protected $model = PortalTag::class;

    public function definition(): array
    {
        return [
            'slug' => fake()->unique()->slug,
            'icon' => 'fas fa-tag',
        ];
    }
}
