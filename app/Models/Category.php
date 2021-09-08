<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'id_cat';

    protected static function booted()
    {
        self::created(function ($model) {
            $model->cat_order = Category::max('cat_order') + 1;
        });
    }

    public function boards(): HasMany
    {
        return $this->hasMany(Board::class, 'id_cat', 'id_cat');
    }
}
