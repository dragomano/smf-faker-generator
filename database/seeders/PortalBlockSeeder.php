<?php

namespace Database\Seeders;

use App\Models\LpBlock;
use App\Models\LpTitle;
use Bugo\FontAwesomeHelper\RegularIcon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PortalBlockSeeder extends Seeder
{
    public function run(): void
    {
        collect(['header', 'top', 'left', 'right', 'bottom', 'footer'])->each(function ($value) {
            $regularIcon = new RegularIcon(['deprecated_class' => true]);

            $block = LpBlock::factory()
                ->sequence(fn() => ['icon' => $regularIcon->random()])
                ->create(['placement' => $value]);

            LpTitle::factory()->createMany([
                [
                    'item_id' => $block->block_id,
                    'type' => 'block',
                    'lang' => 'english',
                    'title' => 'Block ' . Str::headline($value) . ' #' . $block->block_id,
                ],
                [
                    'item_id' => $block->block_id,
                    'type' => 'block',
                    'lang' => 'russian',
                    'title' => 'Блок ' . Str::headline($value) . ' #' . $block->block_id,
                ],
            ]);
        });
    }
}
