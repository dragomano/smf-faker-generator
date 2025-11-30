<?php

namespace Database\Factories;

use App\Models\PortalBlock;
use Illuminate\Database\Eloquent\Factories\Factory;

class PortalBlockFactory extends Factory
{
    protected $model = PortalBlock::class;

    public function definition(): array
    {
        return [
            'icon' => fake()->unique()->randomElement([
                'fas fa-thumbs-up',
                'fas fa-thumbs-down',
                'fas fa-heart',
                'fas fa-star',
                'fas fa-flag',
                'fas fa-cat',
            ]),
            'type' => 'html',
            'placement' => fake()->randomElement(['header', 'top', 'left', 'right', 'bottom', 'footer']),
            'permissions' => 3,
            'title_class' => 'cat_bar',
            'content_class' => 'roundframe',
        ];
    }

    public function type($type): self
    {
        return $this->state(fn(array $attributes) => [
            'type' => $type,
        ]);
    }
}
