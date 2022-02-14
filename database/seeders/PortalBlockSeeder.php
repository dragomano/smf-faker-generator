<?php

namespace Database\Seeders;

use App\Models\LpBlock;
use App\Models\LpTitle;
use Illuminate\Database\Seeder;

class PortalBlockSeeder extends Seeder
{
    public function run()
    {
        collect(['header', 'top', 'left', 'right', 'bottom', 'footer'])->each(function ($value) {
            $block = LpBlock::factory()->create(['placement' => $value]);

            LpTitle::factory()->createMany([
                [
                    'item_id' => $block->block_id,
                    'type' => 'block',
                    'lang' => 'english',
                    'title' => $value . ' #' . $block->block_id
                ],
                [
                    'item_id' => $block->block_id,
                    'type' => 'block',
                    'lang' => 'russian',
                    'title' => $value . ' #' . $block->block_id
                ],
            ]);
        });
    }
}
