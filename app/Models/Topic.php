<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'id_topic';

    protected $fillable = [
        'id_last_msg'
    ];

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class, 'id_board', 'id_board');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'id_member_started', 'id_member');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'id_topic', 'id_topic');
    }
}
