<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LpTitle extends Model
{
    use HasFactory;

    public $timestamps = false;

    public $incrementing = false;

    public function block(): BelongsTo
    {
        return $this->belongsTo(LpBlock::class, 'item_id', 'block_id');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(LpPage::class, 'item_id', 'page_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(LpCategory::class, 'item_id', 'category_id');
    }

    public function tag(): BelongsTo
    {
        return $this->belongsTo(LpTag::class, 'item_id', 'tag_id');
    }
}
