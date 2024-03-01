<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class LpTag extends Model
{
    use HasFactory;

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
}
