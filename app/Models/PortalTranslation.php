<?php

namespace App\Models;

use App\Observers\TranslationObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

#[ObservedBy([TranslationObserver::class])]
class PortalTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'lp_translations';

    protected $fillable = ['item_id', 'type', 'lang', 'title', 'content', 'description'];

    public function translatable(): MorphTo
    {
        return $this->morphTo('translatable', 'type', 'item_id');
    }
}
