<?php

namespace Database\Seeders;

use App\Models\Membergroup;
use Illuminate\Database\Seeder;

class MembergroupSeeder extends Seeder
{
    public function run(): void
    {
        Membergroup::factory()->createMany([
            [
                'group_name' => 'Administrator',
                'description' => '',
                'online_color' => '#FF0000',
                'icons' => '5#iconadmin.png',
                'group_type' => 1,
            ],
            [
                'group_name' => 'Global Moderator',
                'description' => '',
                'online_color' => '#0000FF',
                'icons' => '5#icongmod.png',
            ],
            [
                'group_name' => 'Moderator',
                'description' => '',
                'icons' => '5#iconmod.png',
            ],
            [
                'group_name' => 'Newbie',
                'description' => '',
                'min_posts' => 0,
                'icons' => '1#icon.png',
            ],
            [
                'group_name' => 'Jr. Member',
                'description' => '',
                'min_posts' => 50,
                'icons' => '2#icon.png',
            ],
            [
                'group_name' => 'Full Member',
                'description' => '',
                'min_posts' => 100,
                'icons' => '3#icon.png',
            ],
            [
                'group_name' => 'Sr. Member',
                'description' => '',
                'min_posts' => 250,
                'icons' => '4#icon.png',
            ],
            [
                'group_name' => 'Hero Member',
                'description' => '',
                'min_posts' => 500,
                'icons' => '5#icon.png',
            ]
        ]);

        Membergroup::factory(10)->create();
    }
}
