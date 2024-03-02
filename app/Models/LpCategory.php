<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LpCategory extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'category_id';

    public function pages(): HasMany
    {
        return $this->hasMany(LpPage::class, 'category_id', 'category_id');
    }

    public function titles(): HasMany
    {
        return $this->hasMany(LpTitle::class, 'item_id', 'category_id')->where('type', 'category');
    }
}
