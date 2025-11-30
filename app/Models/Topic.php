<?php

namespace App\Models;

use App\Observers\TopicObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[ObservedBy([TopicObserver::class])]
class Topic extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'id_topic';

    protected $with = ['firstMessage', 'board', 'member'];

    protected $fillable = [
        'is_sticky',
        'id_board',
        'id_first_msg',
        'id_last_msg',
        'id_member_started',
        'num_replies',
        'num_views',
        'locked',
        'approved',
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

    public function firstMessage(): HasOne
    {
        return $this->hasOne(Message::class, 'id_msg', 'id_first_msg');
    }

    public function lastMessage(): HasOne
    {
        return $this->hasOne(Message::class, 'id_msg', 'id_last_msg');
    }
}
