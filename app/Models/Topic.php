<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'id_topic';

    protected $fillable = [
        'id_last_msg'
    ];

    public static function booted()
    {
        self::created(function($model) {
            $message = Message::factory()->withRandomImage()->create([
                'id_topic' => $model->id_topic,
                'id_board' => $model->id_board,
                'id_member' => $model->id_member_started,
                'poster_name' => $model->member->real_name,
                'poster_email' => $model->member->email_address,
            ]);

            $model->update([
                'id_first_msg' => $message->id_msg,
                'id_last_msg' => $message->id_msg
            ]);
        });
    }

    public function board()
    {
        return $this->belongsTo(Board::class, 'id_board', 'id_board');
    }

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member_started', 'id_member');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'id_topic', 'id_topic');
    }
}
