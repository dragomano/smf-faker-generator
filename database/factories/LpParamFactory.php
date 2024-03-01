<?php

namespace Database\Factories;

use App\Models\LpParam;
use Illuminate\Database\Eloquent\Factories\Factory;

class LpParamFactory extends Factory
{
    protected $model = LpParam::class;

    public function definition(): array
    {
        return [
            'name' => '',
            'value' => '',
        ];
    }
}
