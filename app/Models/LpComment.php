<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LpComment extends Model
{
    use HasFactory;

    public $timestamps = false;

    public static function booted()
    {
        self::created(function($model) {
            $model->page->increment('num_comments');
        });

        self::deleted(function($model) {
            $model->page->decrement('num_comments');
        });
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'author_id', 'id_member');
    }

    public function page()
    {
        return $this->belongsTo(LpPage::class, 'page_id');
    }
}
