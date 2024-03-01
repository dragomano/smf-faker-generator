<?php

namespace Database\Factories;

use App\Models\LpTag;
use Illuminate\Database\Eloquent\Factories\Factory;

class LpTagFactory extends Factory
{
    protected $model = LpTag::class;

    public function definition(): array
    {
        return [
            'icon' => 'fas fa-tag',
        ];
    }
}
