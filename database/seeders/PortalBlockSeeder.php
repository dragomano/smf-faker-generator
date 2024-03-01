<?php

namespace Database\Seeders;

use App\Models\LpBlock;
use App\Models\LpTitle;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PortalBlockSeeder extends Seeder
{
    public function run(): void
    {
        collect(['header', 'top', 'left', 'right', 'bottom', 'footer'])->each(function ($value) {
            $block = LpBlock::factory()->create(['placement' => $value]);

            LpTitle::factory()->create([
                'item_id' => $block->block_id,
                'type' => 'block',
                'lang' => 'english',
                'title' => 'Block ' . Str::headline($value) . ' #' . $block->block_id
            ]);

            LpTitle::factory()->create([
                'item_id' => $block->block_id,
                'type' => 'block',
                'lang' => 'russian',
                'title' => 'Блок ' . Str::headline($value) . ' #' . $block->block_id
            ]);
        });
    }
}
