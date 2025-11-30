<?php

namespace App\Models;

use App\Observers\CategoryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([CategoryObserver::class])]
class Category extends Model
{
    use HasFactory;

	public $timestamps = false;

    protected $primaryKey = 'id_cat';

    protected $fillable = [
        'cat_order',
        'name',
        'description',
        'can_collapse',
    ];

    public function boards(): HasMany
    {
        return $this->hasMany(Board::class, 'id_cat', 'id_cat');
    }
}
