<?php

namespace App\Models;

use App\Models\Traits\HasUnixTimeFields;
use App\Observers\MessageObserver;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([MessageObserver::class])]
class Message extends Model
{
    use HasFactory, HasUnixTimeFields;

    protected $fillable = [
        'id_topic',
        'id_board',
        'poster_time',
        'id_member',
        'subject',
        'poster_name',
        'poster_email',
        'modified_time',
        'body',
        'approved',
    ];

    public $timestamps = false;

    protected $primaryKey = 'id_msg';

    public function getPosterIpAttribute($value): bool|string
    {
        return inet_ntop($value);
    }

    public function setPosterIpAttribute($value): void
    {
        $this->attributes['poster_ip'] = inet_pton($value);
    }

    public function getPosterTimeAttribute($value): ?Carbon
    {
        return $this->getTimestampAttribute($value);
    }

    public function setPosterTimeAttribute($value): void
    {
        $this->setTimestampAttribute($value, 'poster_time');
    }

    public function scopeWhereIp($query, $ip)
    {
        return $query->where('poster_ip', inet_pton($ip));
    }

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class, 'id_board', 'id_board');
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class, 'id_topic', 'id_topic');
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'id_member', 'id_member');
    }
}
