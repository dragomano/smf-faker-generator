<?php

namespace Database\Seeders;

use App\Models\PortalCategory;
use Bugo\FontAwesome\Icon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PortalCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = PortalCategory::factory(10)
            ->sequence(fn() => ['icon' => Icon::random(useOldStyle: true)])
            ->create();

        $categories->each(function ($category) {
            $category->translations()->createMany([
                [
                    'lang' => 'english',
                    'title' => fake()->unique()->jobTitle,
                    'description' => Str::limit(fake()->paragraphs(rand(1, 2), true), 500),
                ],
                [
                    'lang' => 'russian',
                    'title' => fake('ru_RU')->unique()->jobTitle,
                    'description' => Str::limit(fake()->paragraphs(rand(1, 2), true), 500),
                ],
            ]);
        });
    }
}
