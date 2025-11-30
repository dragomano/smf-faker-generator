<?php

namespace App\Models;

use App\Models\Traits\HasTranslations;
use App\Models\Traits\HasUnixTimeFields;
use App\Observers\PortalCommentObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([PortalCommentObserver::class])]
class PortalComment extends Model
{
    use HasFactory, HasTranslations, HasUnixTimeFields;

    public $timestamps = false;

    protected $table = 'lp_comments';

    protected $fillable = [
        'parent_id',
        'page_id',
        'author_id',
        'created_at',
        'updated_at',
    ];

    protected $with = ['translation'];

    public function getTranslatableFields(): array
    {
        return ['content'];
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

    public function page(): BelongsTo
    {
        return $this->belongsTo(PortalPage::class, 'page_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(PortalComment::class, 'parent_id');
    }
}
