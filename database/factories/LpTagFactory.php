<?php

namespace Database\Factories;

use App\Models\LpTag;
use Illuminate\Database\Eloquent\Factories\Factory;

class LpTagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LpTag::class;

    public function definition(): array
    {
        return [
            'value' => $this->faker->unique()->city()
        ];
    }
}
