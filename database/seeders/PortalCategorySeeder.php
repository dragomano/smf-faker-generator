<?php

namespace Database\Seeders;

use App\Models\LpCategory;
use App\Models\LpTitle;
use Bugo\FontAwesomeHelper\BrandIcon;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PortalCategorySeeder extends Seeder
{
    public function run(): void
    {
        $brandIcon = new BrandIcon(['deprecated_class' => true]);

        $categories = LpCategory::factory(10)
            ->sequence(fn() => ['icon' => $brandIcon->random()])
            ->create();

        $fakerEnglish = Factory::create('en_US');
        $fakerRussian = Factory::create('ru_RU');

        $categories->each(function ($category) use ($fakerEnglish, $fakerRussian) {
            LpTitle::factory()->createMany([
                [
                    'item_id' => $category->category_id,
                    'type' => 'category',
                    'lang' => 'english',
                    'title' => $fakerEnglish->jobTitle(),
                ],
                [
                    'item_id' => $category->category_id,
                    'type' => 'category',
                    'lang' => 'russian',
                    'title' => $fakerRussian->jobTitle(),
                ],
            ]);
        });
    }
}
