<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasFactory;

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

    public function scopeWhereIp($query, $ip)
    {
        return $query->where('poster_ip', inet_pton($ip));
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, 'id_member', 'id_member');
    }

    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class, 'id_topic', 'id_topic');
    }

    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class, 'id_board', 'id_board');
    }
}
