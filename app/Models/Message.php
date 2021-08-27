<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'id_msg';

    public static function booted()
    {
        self::retrieved(function($model) {
            // ... code here
        });

        self::creating(function($model) {
            // ... code here
        });

        self::created(function($model) {
            $model->topic->increment('num_replies');
        });

        self::saving(function($model) {
            // ... code here
        });

        self::saved(function($model) {
            $model->topic->update(['id_last_msg' => $model->id_msg]);
        });

        self::updating(function($model) {
            // ... code here
        });

        self::updated(function($model) {
            // ... code here
        });

        self::deleting(function($model) {
            // ... code here
        });

        self::deleted(function($model) {
            $model->topic->decrement('num_replies');

            if (empty($lastMsg = $model->topic->messages->last()->id_msg)) {
                $model->topic->delete();
            } else {
                $model->topic->update(['id_last_msg' => $lastMsg]);
            }
        });
    }

    public function getPosterIpAttribute($value)
    {
        return inet_ntop($value);
    }

    public function setPosterIpAttribute($value)
    {
        $this->attributes['poster_ip'] = inet_pton($value);
    }

    public function scopeWhereIp($query, $ip)
    {
        return $query->where('poster_ip', inet_pton($ip));
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member', 'id_member');
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'id_topic', 'id_topic');
    }

    public function board()
    {
        return $this->belongsTo(Board::class, 'id_board', 'id_board');
    }
}
