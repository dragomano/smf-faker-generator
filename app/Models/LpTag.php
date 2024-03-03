<?php

namespace App\Models;

use App\Traits\WithTitle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LpTag extends Model
{
    use HasFactory, WithTitle;

    public $timestamps = false;

    protected $primaryKey = 'tag_id';

    public static function booted(): void
    {
        self::deleted(function($model) {
            $model->pages()->detach();
        });
    }

    public function pages(): BelongsToMany
    {
        return $this->belongsToMany(LpPage::class, 'lp_page_tags', 'tag_id', 'page_id');
    }

    public function titles(): HasMany
    {
        return $this->hasMany(LpTitle::class, 'item_id', 'tag_id')->where('type', 'tag');
    }
}
