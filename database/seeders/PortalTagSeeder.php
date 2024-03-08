<?php

namespace Database\Seeders;

use App\Models\LpTag;
use App\Models\LpTitle;
use Bugo\FontAwesomeHelper\SolidIcon;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PortalTagSeeder extends Seeder
{
    public function run(): void
    {
        $solidIcon = new SolidIcon(['deprecated_class' => true]);

        $tags = LpTag::factory(30)
            ->sequence(fn() => ['icon' => $solidIcon->random()])
            ->create();

        $fakerEnglish = Factory::create('en_US');
        $fakerRussian = Factory::create('ru_RU');

        $tags->each(function ($tag) use ($fakerEnglish, $fakerRussian) {
            LpTitle::factory()->createMany([
                [
                    'item_id' => $tag->tag_id,
                    'type' => 'tag',
                    'lang' => 'english',
                    'title' => $fakerEnglish->unique()->city,
                ],
                [
                    'item_id' => $tag->tag_id,
                    'type' => 'tag',
                    'lang' => 'russian',
                    'title' => $fakerRussian->unique()->city,
                ],
            ]);
        });
    }
}
