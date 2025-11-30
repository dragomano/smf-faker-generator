<?php

namespace App\Models;

use App\Models\Traits\HasParams;
use App\Models\Traits\HasTranslations;
use App\Models\Traits\HasUnixTimeFields;
use App\Observers\PortalPageObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([PortalPageObserver::class])]
class PortalPage extends Model
{
    use HasFactory, HasParams, HasTranslations, HasUnixTimeFields;

    public $timestamps = false;

    protected $table = 'lp_pages';

    protected $primaryKey = 'page_id';

    protected $fillable = [
        'category_id', 'author_id', 'slug', 'type', 'permissions', 'status', 'num_views', 'num_comments',
        'created_at', 'updated_at', 'deleted_at', 'last_comment_id',
    ];

    protected $with = ['translation'];

    protected function getEntityName(): string
    {
        return 'page';
    }

    public function getCreatedAtAttribute($value): ?Carbon
    {
        return $this->getTimestampAttribute($value);
    }

    public function setCreatedAtAttribute($value): void
    {
        $this->setTimestampAttribute($value, 'created_at');
    }

    public function getUpdatedAtAttribute($value): ?Carbon
    {
        return $this->getTimestampAttribute($value);
    }

    public function setUpdatedAtAttribute($value): void
    {
        $this->setTimestampAttribute($value, 'updated_at');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'author_id', 'id_member');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PortalCategory::class, 'category_id', 'category_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(PortalTag::class, 'lp_page_tag', 'page_id', 'tag_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(PortalComment::class, 'page_id');
    }
}
