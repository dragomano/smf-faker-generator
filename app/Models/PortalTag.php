<?php

namespace App\Models;

use App\Models\Traits\HasTranslations;
use App\Observers\PortalTagObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[ObservedBy([PortalTagObserver::class])]
class PortalTag extends Model
{
    use HasFactory, HasTranslations;

    public $timestamps = false;

    protected $table = 'lp_tags';

    protected $primaryKey = 'tag_id';

    protected $fillable = ['slug', 'icon', 'status'];

    protected $with = ['translation'];

    public function getTranslatableFields(): array
    {
        return ['title'];
    }

    public function pages(): BelongsToMany
    {
        return $this->belongsToMany(
            PortalPage::class,
            'lp_page_tag',
            'tag_id',
            'page_id'
        );
    }
}
