<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Board extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'id_board';

    protected static function booted()
    {
        self::created(function ($model) {
            $model->board_order = Board::max('board_order') + 1;
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_cat', 'id_cat');
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class, 'id_board', 'id_board');
    }
}
