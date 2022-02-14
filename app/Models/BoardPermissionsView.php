<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BoardPermissionsView extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $incrementing = false;

    protected $table = 'board_permissions_view';

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class, 'id_board', 'id_board');
    }
}
