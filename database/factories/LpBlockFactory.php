<?php

namespace Database\Factories;

use App\Models\LpBlock;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class LpBlockFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LpBlock::class;

    public function definition(): array
    {
        return [
            'type' => 'html',
            'note' => Str::ucfirst($this->faker->unique()->words(rand(3, 10), true)),
            'content' => $this->faker->paragraphs(rand(1, 6), true),
            'placement' => $this->faker->randomElement(['header', 'top', 'left', 'right', 'bottom', 'footer']),
            'permissions' => 3,
            'title_class' => 'cat_bar',
            'title_style' => 'background: ' . $this->getRandomColor(),
            'content_class' => 'roundframe',
            'content_style' => 'background: ' . $this->getRandomColor(),
        ];
    }

    private function getRandomColor(): string
    {
        return Str::lower(sprintf('#%06X', mt_rand(0, 0xFFFFFF)));
    }

    public function type($type): Factory
    {
        return $this->state(fn(array $attributes) => [
            'type' => $type,
        ]);
    }
}
