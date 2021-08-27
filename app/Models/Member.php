<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Member extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false;

    protected $primaryKey = 'id_member';

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'member_name',
        'email_address',
        'passwd',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'passwd',
    ];

    public function topics()
    {
        return $this->hasMany(Topic::class, 'id_member_started', 'id_member');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'id_member', 'id_member');
    }

    public function pages()
    {
        return $this->hasMany(LpPage::class, 'author_id', 'id_member');
    }

    public function comments()
    {
        return $this->hasMany(LpComment::class, 'author_id', 'id_member');
    }
}
