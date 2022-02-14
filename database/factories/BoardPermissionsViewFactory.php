<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BoardPermissionsViewFactory extends Factory
{
    public function definition(): array
    {
        return [
            'deny' => 0,
        ];
    }
}
