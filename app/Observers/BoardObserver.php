<?php

namespace App\Observers;

use App\Models\Board;
use App\Models\BoardPermissionsView;

class BoardObserver
{
    public function created(Board $board): void
    {
        BoardPermissionsView::factory()->createMany([
            ['id_group' => -1, 'id_board' => $board->id_board],
            ['id_group' => 0, 'id_board' => $board->id_board],
        ]);
    }
}
