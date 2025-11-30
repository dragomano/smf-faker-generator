<?php

namespace App\Models;

use App\Models\Traits\HasUnixTimeFields;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class Member extends Authenticatable
{
    use HasFactory, HasUnixTimeFields, Notifiable;

    public $timestamps = false;

    protected $primaryKey = 'id_member';

    protected $with = ['group'];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'member_name',
        'email_address',
        'id_group',
        'real_name',
        'passwd',
        'date_registered',
        'birthdate',
        'is_activated',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'passwd',
    ];

    public function getDateRegisteredAttribute($value): ?Carbon
    {
        return $this->getTimestampAttribute($value);
    }

    public function setDateRegisteredAttribute($value): void
    {
        $this->setTimestampAttribute($value, 'date_registered');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Membergroup::class, 'id_group', 'id_group');
    }

    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class, 'id_member_started', 'id_member');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'id_member', 'id_member');
    }

    public function pages(): HasMany
    {
        return $this->hasMany(PortalPage::class, 'author_id', 'id_member');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(PortalComment::class, 'author_id', 'id_member');
    }

    public static function getHashedPassword(string $name, string $password): string
    {
        return password_hash(Str::lower($name) . $password, PASSWORD_BCRYPT);
    }
}
