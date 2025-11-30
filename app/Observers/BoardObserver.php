<?php

namespace App\Observers;

use App\Models\Board;

class BoardObserver
{
    public function created(Board $board): void
    {
        $board->increment('board_order', Board::max('board_order') + 1);

        $board->boardPermissions()->createMany([
            ['id_group' => -1, 'deny' => 0],
            ['id_group' => 0, 'deny' => 0],
        ]);
    }
}
