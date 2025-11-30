<?php

namespace App\Models;

use App\Models\Traits\HasTranslations;
use App\Observers\PortalCategoryObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([PortalCategoryObserver::class])]
class PortalCategory extends Model
{
    use HasFactory, HasTranslations;

    public $timestamps = false;

    protected $table = 'lp_categories';

    protected $primaryKey = 'category_id';

    protected $fillable = ['parent_id', 'slug', 'icon', 'priority', 'status'];

    protected $with = ['translation'];

    public function getTranslatableFields(): array
    {
        return ['title', 'description'];
    }

    public function pages(): HasMany
    {
        return $this->hasMany(PortalPage::class, 'category_id', 'category_id');
    }
}
