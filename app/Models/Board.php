<?php

namespace App\Models;

use App\Observers\BoardObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([BoardObserver::class])]
class Board extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'id_board';

    protected $fillable = [
        'id_cat',
        'child_level',
        'id_parent',
        'board_order',
        'member_groups',
        'name',
        'description',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Board::class, 'id_parent');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'id_cat', 'id_cat');
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class, 'id_board', 'id_board');
    }

    public function boardPermissions(): HasMany
    {
        return $this->hasMany(BoardPermissionsView::class, 'id_board', 'id_board');
    }
}
