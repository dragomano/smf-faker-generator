<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class PortalParam extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'lp_params';

    protected $fillable = ['item_id', 'type', 'name', 'value'];

    public function block(): BelongsTo
    {
        return $this->belongsTo(PortalBlock::class, 'item_id', 'block_id')
            ->where('type', 'block');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(PortalPage::class, 'item_id', 'page_id')
            ->where('type', 'page');
    }
}
