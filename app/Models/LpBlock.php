<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LpBlock extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'block_id';

    public function params(): HasMany
    {
        return $this->hasMany(LpParam::class, 'item_id', 'block_id')->where('type', 'block');
    }

    public function titles(): HasMany
    {
        return $this->hasMany(LpTitle::class, 'item_id', 'block_id')->where('type', 'block');
    }
}
