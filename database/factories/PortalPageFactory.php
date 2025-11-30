<?php

namespace Database\Factories;

use App\Models\PortalCategory;
use App\Models\PortalPage;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class PortalPageFactory extends Factory
{
    protected $model = PortalPage::class;

    public function definition(): array
    {
        return [
            'category_id' => fn() => PortalCategory::inRandomOrder()->value('category_id'),
            'author_id' => fn() => Member::inRandomOrder()->value('id_member'),
            'slug' => fake()->unique()->slug,
            'type' => fake()->randomElement(['bbc', 'html', 'markdown']),
            'entry_type' => fake()->randomElement(['default', 'internal', 'draft']),
            'permissions' => 3,
            'num_views' => mt_rand(0, 9999),
        ];
    }
}
