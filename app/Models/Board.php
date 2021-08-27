<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'id_board';

    public function category()
    {
        return $this->belongsTo(Category::class, 'id_cat', 'id_cat');
    }

    public function topics()
    {
        return $this->hasMany(Topic::class, 'id_board', 'id_board');
    }
}
