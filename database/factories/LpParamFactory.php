<?php

namespace Database\Factories;

use App\Models\LpParam;
use Illuminate\Database\Eloquent\Factories\Factory;

class LpParamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LpParam::class;

    public function definition(): array
    {
        return [
            'name' => '',
            'value' => '',
        ];
    }
}
