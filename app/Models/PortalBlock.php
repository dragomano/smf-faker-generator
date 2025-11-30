<?php

namespace App\Models;

use App\Models\Traits\HasParams;
use App\Models\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortalBlock extends Model
{
    use HasFactory, HasParams, HasTranslations;

    public $timestamps = false;

    protected $table = 'lp_blocks';

    protected $primaryKey = 'block_id';

    protected $fillable = [
        'icon',
        'type',
        'placement',
        'priority',
        'permissions',
        'status',
        'areas',
        'title_class',
        'content_class',
    ];

    protected $with = ['translation'];

    protected function getEntityName(): string
    {
        return 'block';
    }
}
