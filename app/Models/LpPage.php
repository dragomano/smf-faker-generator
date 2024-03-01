<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LpPage extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'page_id';

    public static function booted(): void
    {
        self::created(function($model) {
            $model->update([
                'num_comments' => $model->comments->count()
            ]);
        });

        self::deleted(function($model) {
            $model->comments->each->delete();
            $model->tags()->detach();
        });
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'author_id', 'id_member');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(LpCategory::class, 'category_id', 'category_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(LpTag::class, 'lp_page_tags', 'page_id', 'tag_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(LpComment::class, 'page_id');
    }
}
