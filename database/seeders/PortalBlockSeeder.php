<?php

namespace Database\Seeders;

use App\Models\PortalBlock;
use Bugo\FontAwesome\Icon;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PortalBlockSeeder extends Seeder
{
    public function run(): void
    {
        collect(['header', 'top', 'left', 'right', 'bottom', 'footer'])->each(function ($value) {
            try {
                $block = PortalBlock::factory()
                    ->sequence(fn() => ['icon' => Icon::random(useOldStyle: true)])
                    ->create(['placement' => $value]);

                /* @var PortalBlock $block */
                $block->translations()->createMany([
                    [
                        'lang' => 'english',
                        'title' => 'Block ' . Str::headline($value) . ' #' . $block->block_id,
                        'content' => fake()->paragraphs(1, true),
                    ],
                    [
                        'lang' => 'russian',
                        'title' => 'Блок ' . Str::headline($value) . ' #' . $block->block_id,
                        'content' => fake()->paragraphs(1, true),
                    ],
                ]);
            } catch (Exception) {}
        });
    }
}
