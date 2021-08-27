<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'id_cat';

    public function boards()
    {
        return $this->hasMany(Board::class, 'id_cat', 'id_cat');
    }
}
