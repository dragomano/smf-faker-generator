<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LpBlock extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'block_id';

    public function params()
    {
        return $this->hasManyThrough(LpTag::class, LpParam::class, 'item_id', 'tag_id', 'block_id');
    }
}
