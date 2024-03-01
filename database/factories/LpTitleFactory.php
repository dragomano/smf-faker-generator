<?php

namespace Database\Factories;

use App\Models\LpTitle;
use Illuminate\Database\Eloquent\Factories\Factory;

class LpTitleFactory extends Factory
{
    protected $model = LpTitle::class;

    public function definition(): array
    {
        return [
            'lang' => 'english',
            'title' => rtrim($this->faker->sentence, '.'),
        ];
    }
}
