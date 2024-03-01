<?php

namespace Database\Seeders;

use App\Models\LpTag;
use App\Models\LpTitle;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PortalTagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = LpTag::factory(30)->create();

        $fakerEnglish = Factory::create();

        $tags->each(function ($tag) use ($fakerEnglish) {
            LpTitle::factory()->create([
                'item_id' => $tag->tag_id,
                'type' => 'tag',
                'lang' => 'english',
                'title' => $fakerEnglish->unique()->city,
            ]);
        });

        $fakerRussian = Factory::create('ru_RU');

        $tags->each(function ($tag) use ($fakerRussian) {
            LpTitle::factory()->create([
                'item_id' => $tag->tag_id,
                'type' => 'tag',
                'lang' => 'russian',
                'title' => $fakerRussian->unique()->city,
            ]);
        });
    }
}
