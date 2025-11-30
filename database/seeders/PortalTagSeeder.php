<?php

namespace Database\Seeders;

use App\Models\PortalTag;
use Bugo\FontAwesome\Icon;
use Illuminate\Database\Seeder;

class PortalTagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = PortalTag::factory(30)
            ->sequence(fn() => ['icon' => Icon::random(useOldStyle: true)])
            ->create();

        $tags->each(function ($tag) {
            $tag->translations()->createMany([
                [
                    'lang' => 'english',
                    'title' => fake()->unique()->city,
                ],
                [
                    'lang' => 'russian',
                    'title' => fake('ru_RU')->unique()->city,
                ],
            ]);
        });
    }
}
