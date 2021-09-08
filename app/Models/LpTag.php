<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LpTag extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'tag_id';
}
