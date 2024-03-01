<?php

namespace Database\Seeders;

use App\Models\LpCategory;
use App\Models\LpTitle;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PortalCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = LpCategory::factory(10)->create();

        $fakerEnglish = Factory::create();

        $categories->each(function ($category) use ($fakerEnglish) {
            LpTitle::factory()->create([
                'item_id' => $category->category_id,
                'type' => 'category',
                'lang' => 'english',
                'title' => $fakerEnglish->jobTitle(),
            ]);
        });

        $fakerRussian = Factory::create('ru_RU');

        $categories->each(function ($category) use ($fakerRussian) {
            LpTitle::factory()->create([
                'item_id' => $category->category_id,
                'type' => 'category',
                'lang' => 'russian',
                'title' => $fakerRussian->jobTitle(),
            ]);
        });
    }
}
