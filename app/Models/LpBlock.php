<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class LpBlock extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'block_id';

    public function params(): HasManyThrough
    {
        return $this->hasManyThrough(LpTag::class, LpParam::class, 'item_id', 'tag_id', 'block_id');
    }
}
