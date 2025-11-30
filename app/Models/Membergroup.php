<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Membergroup extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'id_group';

    protected $fillable = [
        'group_name',
        'description',
        'online_color',
        'min_posts',
    ];

    public function members(): HasMany
    {
        return $this->hasMany(Member::class, 'id_group', 'id_group');
    }
}
