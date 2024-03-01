<?php

namespace Database\Factories;

use App\Models\LpBlock;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LpBlockFactory extends Factory
{
    protected $model = LpBlock::class;

    public function definition(): array
    {
        return [
            'icon' => $this->faker->unique()->randomElement(['fas fa-thumbs-up', 'fas fa-thumbs-down', 'fas fa-heart', 'fas fa-star', 'fas fa-flag', 'fas fa-cat']),
            'type' => 'html',
            'note' => Str::ucfirst($this->faker->unique()->words(rand(3, 10), true)),
            'content' => $this->faker->paragraphs(rand(1, 6), true),
            'placement' => $this->faker->randomElement(['header', 'top', 'left', 'right', 'bottom', 'footer']),
            'permissions' => 3,
            'title_class' => 'cat_bar',
            'content_class' => 'roundframe',
        ];
    }

    public function type($type): Factory
    {
        return $this->state(fn(array $attributes) => [
            'type' => $type,
        ]);
    }
}
